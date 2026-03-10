# LearnHub - Mini Plateforme de Cours en Ligne

## 1. Description du projet
LearnHub est une mini plateforme de cours en ligne développée avec Symfony 6.4, conçue pour permettre aux étudiants et enseignants de partager des connaissances sous forme de cours. Le projet répond aux exigences académiques B3 en intégrant les fondamentaux du développement web moderne : architecture MVC, persistance des données via ORM, authentification sécurisée et interface soignée.

Thème : **Plateforme de Cours en Ligne**
Cible : Étudiants et corps professoral.

## 2. Choix techniques
- **Framework** : Symfony 6.4 (LTS) pour sa robustesse et son adhésion aux standards PSR.
- **Langage** : PHP 8.5 (compatible PHP 8.1+).
- **Base de Données** : SQLite pour la portabilité (facilement interchangeable avec MySQL/PostgreSQL via `.env`).
- **ORM** : Doctrine pour l'abstraction de la base de données.
- **Frontend** : Twig pour le templating, Bootstrap 5 pour la structure responsive, et CSS personnalisé pour l'esthétique "Rich & Modern" (Glassmorphism, Gradients).
- **Sécurité** : Symfony Security Bundle (Auth form, Hashage de mots de passe, CSRF, Votes).

## 3. Instructions d'installation

### Prérequis
- PHP >= 8.1
- Composer
- Symfony CLI (recommandé)

### Installation
1. Cloner le dépôt :
   ```bash
   git clone <url_du_repo>
   cd Projet
   ```

2. Installer les dépendances :
   ```bash
   composer install
   ```

3. Configurer la base de données :
   Par défaut, le projet utilise SQLite (`var/data.db`). Aucune configuration requise.

4. Initialiser la base de données :
   ```bash
   php bin/console doctrine:database:create
   php bin/console doctrine:migrations:migrate
   ```

5. Charger les données de test (Fixtures) :
   ```bash
   php bin/console doctrine:fixtures:load
   ```

6. Lancer le serveur :
   ```bash
   symfony server:start
   # ou
   php -S 127.0.0.1:8000 -t public
   ```

### Script d'installation automatique
Un script `install.sh` est fourni à la racine :
```bash
chmod +x install.sh
./install.sh
```

## 4. Comptes de test

Les fixtures génèrent trois comptes principaux avec des rôles différents :

| Rôle | Email | Mot de passe | Permissions |
|------|-------|--------------|-------------|
| **Administrateur** | `admin@learnhub.com` | `password` | Gestion complète : utilisateurs, tous les cours, commentaires |
| **Professeur** | `prof@learnhub.com` | `password` | Créer/modifier/supprimer ses propres cours, commenter |
| **Élève** | `eleve@learnhub.com` | `password` | Consulter les cours, commenter |

### Hiérarchie des rôles
- `ROLE_USER` : Rôle de base (élève)
- `ROLE_PROF` : Hérite de ROLE_USER + peut gérer les cours
- `ROLE_ADMIN` : Hérite de ROLE_PROF + peut gérer les utilisateurs

## 5. Difficultés rencontrées
- **Configuration des dépendances** : Conflit initial entre `property-info` et `reflection-docblock`, résolu en fixant la version correcte.
- **Stylisation avancée** : Intégration du thème sombre ("Rich Aesthetics") avec Bootstrap tout en gardant un code CSS maintenable.
- **Sécurité** : Mise en place des permissions fines pour l'édition/suppression des cours via les Voters (simplifié ici par des vérifications contrôleur).

## 6. Pistes d'amélioration
- **Voters** : Implémenter des classes Voter dédiées pour sortir la logique d'autorisation des contrôleurs.
- **Upload d'images** : Permettre d'ajouter une image de couverture aux cours.
- **API** : Exposer les cours via API Platform pour une consommation mobile.
- **Recherche** : Ajouter un moteur de recherche (Elasticsearch ou simple LIKE SQL).
