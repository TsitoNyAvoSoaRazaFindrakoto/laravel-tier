#!/bin/bash

# Attendre que la base de données PostgreSQL soit prête
echo "Waiting for PostgreSQL to be ready..."
until pg_isready -h postgres_tier -p 5432; do
  sleep 1
done

# Exécuter les migrations Laravel
echo "Running Laravel migrations..."
php artisan migrate --force

# Exécuter init.sql si disponible
if [ -f "/var/www/html/app/init-scripts/init.sql" ]; then
    echo "Executing init.sql..."
    PGPASSWORD=fifaliana psql -U postgres -h postgres_tier -d crypto -f /var/www/html/app/init-scripts/init.sql
    if [ $? -eq 0 ]; then
        echo "init.sql executed successfully."
    else
        echo "Error executing init.sql."
        exit 1
    fi
fi

# Lancer le serveur Laravel
php artisan serve:with-crypto --host=0.0.0.0 --port=8000
