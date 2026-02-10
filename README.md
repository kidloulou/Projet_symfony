# 📚 Projet B3 - Développement Web

Ce dossier contient les projets de développement web du cursus B3.

## 📂 Structure

```
Projet/
└── intro_symfony/     # Projet d'introduction à Symfony 6.4
    ├── src/           # Code source PHP
    ├── templates/     # Templates Twig
    ├── public/        # Point d'entrée web
    ├── config/        # Configuration
    ├── assets/        # JavaScript et CSS
    └── ...
```

## 🚀 Projets

### intro_symfony

**Description** : Application web LearnHub - Plateforme d'apprentissage en ligne

**Technologies** :
- Symfony 6.4
- Doctrine ORM
- Twig
- Stimulus + Turbo (Hotwired)
- Bootstrap 5

**Fonctionnalités** :
- ✅ Authentification et gestion des utilisateurs
- ✅ Système de rôles (Admin, Professeur, Étudiant)
- ✅ Gestion de cours (CRUD)
- ✅ Système de commentaires
- ✅ Dashboard administrateur
- ✅ Interface responsive

**Comment démarrer** :
```bash
cd intro_symfony
./install.sh
symfony server:start
```

Puis ouvrir : http://localhost:8000

**Comptes de test** :
- Admin : `admin@learnhub.com` / `password`
- Professeur : `prof@learnhub.com` / `password`
- Étudiant : `eleve@learnhub.com` / `password`

---

## 📖 Documentation

Chaque projet contient sa propre documentation dans son dossier respectif.

Pour `intro_symfony`, consultez :
- `intro_symfony/README.md` - Documentation principale
- `intro_symfony/GUIDE_IMPORTATIONS.md` - Guide des dépendances
- `intro_symfony/ANALYSE_DEPENDANCES.md` - Analyse des packages
- `intro_symfony/RESUME_IMPORTATIONS.md` - Résumé des importations

---

## 🛠️ Prérequis Généraux

- PHP 8.1 ou supérieur
- Composer
- Symfony CLI
- Node.js (optionnel, pour certains projets)

---

## 📝 Notes

Ce dossier est organisé pour faciliter la gestion de plusieurs projets Symfony et autres technologies web au cours de l'année.

Chaque sous-dossier est un projet autonome avec ses propres dépendances et configuration.
