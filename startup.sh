#!/bin/bash
# Exécuter les migrations Laravel
php artisan migrate --force

# Exécuter le script SQL
psql -U postgres -d crypto -f /var/www/html/app/init-scripts/init.sql

# Démarrer le serveur Laravel
php artisan serve:with-crypto --host=0.0.0.0 --port=8383