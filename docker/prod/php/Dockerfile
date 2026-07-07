FROM php:8.4-fpm

# Install dependencies
RUN apt-get update && apt-get install -y \
    git curl zip unzip libpq-dev libzip-dev \
    && docker-php-ext-install pdo pdo_pgsql zip opcache

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Salin kode Laravel ke dalam image
COPY src/ .
COPY .env.prod /var/www/html/.env

# Install Laravel dependencies tanpa package dev
RUN composer install --no-dev --optimize-autoloader

# Set permission folder storage
RUN chown -R www-data:www-data /var/www/html/storage
