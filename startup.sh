#!/bin/bash

if [ ! -f "/var/www/html/init.lock" ]; then
    echo "Running initial database setup..."
    php artisan migrate --force
    psql -U postgres -d crypto -f /var/www/html/app/init-scripts/init.sql
    touch /var/www/html/init.lock
else
    echo "Database already initialized, skipping..."
fi

php artisan serve --host=0.0.0.0 --port=8000
