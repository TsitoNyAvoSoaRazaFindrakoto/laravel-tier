#!/bin/bash

if [ ! -f "/var/www/html/init.lock" ]; then
    echo "Running initial database setup..."

    # Exécuter la migration Laravel
    php artisan migrate --force

    # Vérifier si le fichier init.sql existe avant de l'exécuter
    if [ -f "/var/www/html/app/init-scripts/init.sql" ]; then
        echo "Executing init.sql..."
        # Exécution du script SQL dans PostgreSQL (en utilisant le service Docker postgres_tier)
        PGPASSWORD=fifaliana psql -U postgres -h postgres_tier -d crypto -f /var/www/html/app/init-scripts/init.sql

        # Vérifier si le script a été exécuté correctement
        if [ $? -eq 0 ]; then
            echo "init.sql executed successfully."
        else
            echo "Error executing init.sql."
            exit 1  # Quitter en cas d'erreur
        fi
    else
        echo "init.sql not found!"
        exit 1
    fi

    # Créer un fichier de verrouillage pour éviter une exécution répétée
    touch /var/www/html/init.lock
else
    echo "Database already initialized, skipping..."
fi

# Démarrer Laravel
php artisan serve --host=0.0.0.0 --port=8000
