# ---------- PHP Stage ----------
FROM php:8.2-fpm as php

# Install PHP extensions
RUN apt-get update && apt-get install -y \
    git curl zip unzip libpng-dev libonig-dev libxml2-dev \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy app code
COPY . .

# Install dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist

# Set permissions
RUN chown -R www-data:www-data /var/www \
    && chmod -R 775 /var/www/storage /var/www/bootstrap/cache


# ---------- NGINX + PHP-FPM Combined ----------
FROM nginx:alpine as final

# Install PHP-FPM and Supervisor
RUN apk add --no-cache php82 php82-fpm php82-opcache supervisor curl bash

# Copy NGINX config
COPY ./docker/nginx.conf /etc/nginx/conf.d/default.conf

# Copy app from PHP build
COPY --from=php /var/www /var/www

# Set working directory
WORKDIR /var/www

# Expose web port
EXPOSE 9001

# Start NGINX and PHP-FPM via Supervisor
COPY ./docker/supervisord.conf /etc/supervisord.conf
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisord.conf"]
