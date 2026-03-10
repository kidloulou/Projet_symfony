<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Comment;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        $admin = $this->createUser('admin@learnhub.com', ['ROLE_ADMIN'], $manager);
        $prof = $this->createUser('prof@learnhub.com', ['ROLE_PROF'], $manager);
        $eleve = $this->createUser('eleve@learnhub.com', ['ROLE_USER'], $manager);

        $courses = $this->getCoursesData();
        $this->createCoursesWithComments($courses, $admin, $prof, $eleve, $manager);

        $manager->flush();
    }

    private function createUser(string $email, array $roles, ObjectManager $manager): User
    {
        $user = new User();
        $user->setEmail($email);
        $user->setRoles($roles);
        
        $hashedPassword = $this->hasher->hashPassword($user, 'password');
        $user->setPassword($hashedPassword);
        
        $manager->persist($user);
        
        return $user;
    }

    private function getCoursesData(): array
    {
        return [
            [
                'title' => 'Python pour les débutants',
                'description' => 'Apprenez les bases de Python, un langage polyvalent et puissant.',
                'content' => "## Introduction
Python est un langage de programmation interprété, multiparadigme et multiplateformes. Il favorise la programmation impérative structurée, fonctionnelle et orientée objet.

## Ce que vous apprendrez
- Variables et types de données
- Structures de contrôle (if, for, while)
- Fonctions et modules
- Manipulation de fichiers

## Pourquoi Python ?
C'est le langage idéal pour débuter grâce à sa syntaxe claire et lisible."
            ],
            [
                'title' => 'HTML5 & CSS3 : Le Web Moderne',
                'description' => 'Créez des sites web magnifiques et responsives.',
                'content' => "## Structure avec HTML5
HTML5 est la dernière révision majeure d'HTML.
Il apporte de nouvelles balises sémantiques comme <header>, <footer>, <article>, et <section>.

## Style avec CSS3
CSS3 permet de styliser vos pages avec des ombres, des dégradés, des animations et des transitions sans avoir recours à des images complexes.

## Flexbox et Grid
Apprenez à mettre en page vos éléments simplement avec les modules Flexbox et Grid."
            ],
            [
                'title' => 'JavaScript Moderne (ES6+)',
                'description' => 'Maîtrisez le langage qui propulse le web interactif.',
                'content' => "## Les nouveautés ES6
- `let` et `const` pour la déclaration de variables
- Fonctions fléchées `() => {}`
- Template literals `Hello \${name}`
- Destructuring

## Asynchrone
Comprendre les Promises et la syntaxe async/await pour gérer les opérations asynchrones comme les appels API."
            ],
            [
                'title' => 'Les bases de PHP 8',
                'description' => 'Le langage serveur le plus utilisé au monde pour le web.',
                'content' => "## Introduction
PHP est un langage de scripts généraliste et Open Source, spécialement conçu pour le développement d'applications web.

## Fonctionnalités clés
- Typage fort (optionnel mais recommandé)
- Programmation Orientée Objet complète
- Nouveautés PHP 8 : JIT Compiler, Union Types, Named Arguments."
            ],
            [
                'title' => 'Symfony 6 : Le Framework PHP',
                'description' => 'Développez des applications robustes et maintenables.',
                'content' => "## Architecture MVC
Symfony respecte le pattern Modèle-Vue-Contrôleur.

## Composants
Symfony est un ensemble de composants réutilisables.

## Dependency Injection
Le conteneur de services est au cœur de Symfony, permettant une gestion fine des dépendances."
            ],
            [
                'title' => 'React.js : Interfaces Utilisateur',
                'description' => 'La bibliothèque JavaScript de Facebook pour les UI.',
                'content' => "## Composants
Tout est composant dans React. Apprenez à créer des composants réutilisables.

## Hooks
Gérez l'état et les effets de bord avec `useState` et `useEffect`.

## JSX
Une syntaxe qui ressemble à du HTML mais qui possède toute la puissance de JavaScript."
            ],
            [
                'title' => 'SQL et Bases de Données',
                'description' => 'Interrogez et gérez vos données efficacement.',
                'content' => "## SELECT
Récupérer des données.

## JOIN
Lier plusieurs tables entre elles.

## Conception
Normalisation et création de schémas de base de données relationnels performants."
            ],
            [
                'title' => 'Git et GitHub',
                'description' => 'Versionnez votre code et collaborez en équipe.',
                'content' => "## Les bases
`git init`, `git add`, `git commit`, `git push`.

## Branches
Travailler sur des fonctionnalités isolées avec les branches.

## Pull Requests
Revoir et fusionner le code sur GitHub."
            ],
            [
                'title' => 'Docker pour les Développeurs',
                'description' => 'Conteneurisez vos applications pour un déploiement facile.',
                'content' => "## Conteneurs vs VMs
Pourquoi Docker est plus léger.

## Dockerfile
Définir l'image de votre application.

## Docker Compose
Orchestrer plusieurs conteneurs (App, DB, Cache) pour votre environnement de développement."
            ],
            [
                'title' => 'Algorithmique & Structures de Données',
                'description' => 'Les fondements de la science informatique.',
                'content' => "## Complexité
Big O notation.

## Structures
Tableaux, Listes chaînées, Piles, Files, Arbres, Graphes.

## Algorithmes de tri
Tri à bulles, tri rapide (quicksort), tri fusion (mergesort)."
            ]
        ];
    }

    private function createCoursesWithComments(
        array $courses, 
        User $admin, 
        User $prof, 
        User $student, 
        ObjectManager $manager
    ): void {
        foreach ($courses as $index => $courseData) {
            $article = $this->createArticle($courseData, $index, $admin, $prof, $manager);
            $this->createCommentsForArticle($article, $courseData['title'], $student, $manager);
        }
    }

    private function createArticle(
        array $courseData, 
        int $index, 
        User $admin, 
        User $prof, 
        ObjectManager $manager
    ): Article {
        $article = new Article();
        $article->setTitle($courseData['title']);
        $article->setDescription($courseData['description']);
        $article->setContent($courseData['content']);
        $article->setCreatedAt(new \DateTimeImmutable("- $index days"));
        
        $author = $index % 2 === 0 ? $admin : $prof;
        $article->setAuthor($author);
        
        $manager->persist($article);
        
        return $article;
    }

    private function createCommentsForArticle(
        Article $article, 
        string $courseTitle, 
        User $student, 
        ObjectManager $manager
    ): void {
        $commentTexts = [
            "Super cours sur {$courseTitle} ! Très clair.",
            "Super cours sur {$courseTitle} ! J'ai appris beaucoup."
        ];

        foreach ($commentTexts as $commentText) {
            $comment = new Comment();
            $comment->setContent($commentText);
            $comment->setCreatedAt(new \DateTimeImmutable());
            $comment->setAuthor($student);
            $comment->setArticle($article);
            
            $manager->persist($comment);
        }
    }
}
