#!/bin/bash

echo "🚀 Démarrage de l'installation de LearnHub..."

# Vérification de PHP
if ! command -v php &> /dev/null; then
    echo "❌ PHP n'est pas installé."
    exit 1
fi

# Vérification de Composer
if ! command -v composer &> /dev/null; then
    echo "❌ Composer n'est pas installé."
    exit 1
fi

echo "📦 Installation des dépendances Composer..."
composer install

echo "🗄️  Création de la base de données..."
php bin/console doctrine:database:create --if-not-exists

echo "🔄 Application des migrations..."
php bin/console doctrine:migrations:migrate -n

echo "🌱 Chargement des données de test (Fixtures)..."
php bin/console doctrine:fixtures:load -n

echo "✅ Installation terminée avec succès !"
echo "👉 Lancez le serveur avec : symfony server:start"
