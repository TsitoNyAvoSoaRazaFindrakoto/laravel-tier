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

# Copier le script de démarrage et lui donner les permissions d'exécution
COPY startup.sh /usr/local/bin/startup.sh
RUN chmod +x /usr/local/bin/startup.sh

# Configurer Git pour éviter les erreurs de permissions
RUN git config --global --add safe.directory /var/www/html

# Installer les dépendances Laravel et Debugbar
RUN composer install --no-dev --optimize-autoloader --prefer-dist
RUN composer require barryvdh/laravel-debugbar --dev

# Configurer les permissions pour le stockage et le cache de Laravel
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Exposer le port 8000
EXPOSE 8000

# Démarrer Laravel avec le script startup.sh
CMD ["sh", "-c", "/usr/local/bin/startup.sh"]
