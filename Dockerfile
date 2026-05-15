# ────────────────────────────────────────────────────────────
# Stage 1: Build Frontend Assets (Vite)
# ────────────────────────────────────────────────────────────
FROM node:20-alpine AS frontend
WORKDIR /app
COPY package*.json ./
RUN npm install
COPY . .
RUN npm run build

# ────────────────────────────────────────────────────────────
# Stage 2: Build PHP Dependencies (Composer)
# ────────────────────────────────────────────────────────────
FROM composer:2.6 AS vendor
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install \
    --no-dev \
    --no-interaction \
    --prefer-dist \
    --ignore-platform-reqs \
    --no-scripts \
    --no-autoloader
COPY . .
RUN composer dump-autoload --optimize --no-dev

# ────────────────────────────────────────────────────────────
# Stage 3: Production Server (PHP 8.3 + Apache)
# ────────────────────────────────────────────────────────────
FROM php:8.3-apache
WORKDIR /var/www/html

# Install system dependencies & PHP extensions
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip \
    curl \
    && apt-get clean && rm -rf /var/lib/apt/lists/* \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Configure Apache DocumentRoot → /public
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf \
    && sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf \
    && a2enmod rewrite

# Copy aplikasi dari stage build
COPY --from=vendor /app /var/www/html
COPY --from=frontend /app/public/build /var/www/html/public/build

# Set permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Startup script: migrate + seed + jalankan Apache
RUN printf '#!/bin/bash\nset -e\nphp artisan optimize:clear\nphp artisan migrate --force\nphp artisan db:seed --force\napache2-foreground\n' \
    > /usr/local/bin/start.sh \
    && chmod +x /usr/local/bin/start.sh

EXPOSE 80
CMD ["/usr/local/bin/start.sh"]
