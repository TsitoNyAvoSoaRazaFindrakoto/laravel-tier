FROM php:8.2-cli

# Installer les dépendances nécessaires
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libzip-dev \
    unzip \
    git \
    && docker-php-ext-install pdo_pgsql zip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Définir le répertoire de travail
WORKDIR /var/www/html

# Installer Composer
COPY --from=composer:2.8.3 /usr/bin/composer /usr/bin/composer

# Copier le code de l'application
COPY . .

# Configurer Git pour éviter les erreurs de permissions
RUN git config --global --add safe.directory /var/www/html

# Installer les dépendances Laravel et Debugbar
RUN composer install --no-dev --optimize-autoloader --prefer-dist
RUN composer require barryvdh/laravel-debugbar --dev

# Configurer les permissions pour le stockage et le cache de Laravel
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Vérifier si le fichier init.lock existe et exécuter les migrations et le script SQL
RUN if [ ! -f "/var/www/html/init.lock" ]; then \
        echo "Running initial database setup..."; \
        # Exécuter la migration Laravel
        php artisan migrate --force; \
        # Vérifier si le fichier init.sql existe avant de l'exécuter
        if [ -f "/var/www/html/app/init-scripts/init.sql" ]; then \
            echo "Executing init.sql..."; \
            # Exécution du script SQL dans PostgreSQL (en utilisant le service Docker postgres_tier)
            PGPASSWORD=fifaliana psql -U postgres -h postgres_tier -d crypto -f /var/www/html/app/init-scripts/init.sql; \
            # Vérifier si le script a été exécuté correctement
            if [ $? -eq 0 ]; then \
                echo "init.sql executed successfully."; \
            else \
                echo "Error executing init.sql."; \
                exit 1; \
            fi; \
        else \
            echo "init.sql not found!"; \
            exit 1; \
        fi; \
        # Créer un fichier de verrouillage pour éviter une exécution répétée
        touch /var/www/html/init.lock; \
    else \
        echo "Database already initialized, skipping..."; \
    fi

# Exposer le port 8000
EXPOSE 8000

# Démarrer Laravel
CMD php artisan serve --host=0.0.0.0 --port=8000
