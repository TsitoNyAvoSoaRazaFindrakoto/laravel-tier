FROM php:8.2-apache

# Installer les dépendances nécessaires
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libzip-dev \
    unzip \
    git \
    postgresql-client \
    && docker-php-ext-install pdo_pgsql zip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Définir le répertoire de travail
WORKDIR /var/www/html

# Copier le code du projet Laravel
COPY . .

# Copier le fichier de credentials Firebase
COPY ./storage/firebase/keyFirebase.json /var/www/html/storage/firebase/firebase_credentials.json

# Installer Composer
COPY --from=composer:2.8.3 /usr/bin/composer /usr/bin/composer

# Installer les dépendances Laravel avec Composer
RUN composer install --no-dev --optimize-autoloader

# Installer Firebase SDK pour PHP
RUN composer require kreait/firebase-php

# Configurer les permissions pour le stockage et le cache de Laravel
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Activer les modules Apache requis
RUN a2enmod rewrite


# Exposer le port 8000
EXPOSE 8000

# Démarrer Apache et Laravel
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
