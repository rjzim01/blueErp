# Stage 1: install PHP dependencies (vendor) so Tailwind preset is available
FROM php:8.4-apache AS vendor

WORKDIR /var/www/html

RUN apt-get update && apt-get install -y --no-install-recommends \
        git \
        unzip \
        libpng-dev \
        libjpeg62-turbo-dev \
        libfreetype6-dev \
        libicu-dev \
        libzip-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-configure intl \
    && docker-php-ext-install gd intl zip \
    && rm -rf /var/lib/apt/lists/*

COPY . .
# Create runtime directories needed during composer scripts (e.g., cache path)
RUN mkdir -p storage/framework/cache storage/framework/views storage/framework/sessions bootstrap/cache
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && composer install --no-dev --prefer-dist --optimize-autoloader

# Stage 2: build frontend assets with access to vendor/filament preset
FROM node:22-slim AS frontend
WORKDIR /app

COPY package*.json ./
COPY vite.config.js postcss.config.js tailwind.config.js ./
COPY resources ./resources
COPY public ./public
# bring in vendor (for tailwind.config preset)
COPY --from=vendor /var/www/html/vendor ./vendor

RUN npm install \
    && npm run build

# Stage 3: final PHP/Apache image
FROM php:8.4-apache

WORKDIR /var/www/html

RUN apt-get update && apt-get install -y --no-install-recommends \
        build-essential \
        re2c \
        unzip \
        wget \
        git \
        libpng-dev \
        libjpeg62-turbo-dev \
        libfreetype6-dev \
        pkg-config \
        libzip-dev \
        zlib1g-dev \
        libonig-dev \
        libxml2-dev \
        libicu-dev \
        default-mysql-client \
        curl \
        ca-certificates \
        gnupg \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-configure intl \
    && docker-php-ext-install gd bcmath zip mysqli pdo pdo_mysql intl \
    && a2enmod rewrite \
    && curl -fsSL https://deb.nodesource.com/setup_22.x | bash - \
    && apt-get install -y nodejs \
    && rm -rf /var/lib/apt/lists/*

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy application code
COPY . /var/www/html

# Ensure runtime directories exist for cache/sessions/views
RUN mkdir -p storage/framework/cache storage/framework/views storage/framework/sessions storage/logs bootstrap/cache

# Copy vendor from composer stage (instead of running composer again)
COPY --from=vendor /var/www/html/vendor /var/www/html/vendor

# Copy built frontend assets
COPY --from=frontend /app/public/build /var/www/html/public/build

# Configure PHP for large data processing
RUN echo "max_execution_time = 300" >> /usr/local/etc/php/php.ini \
    && echo "max_input_time = 300" >> /usr/local/etc/php/php.ini \
    && echo "memory_limit = 512M" >> /usr/local/etc/php/php.ini \
    && echo "post_max_size = 100M" >> /usr/local/etc/php/php.ini \
    && echo "upload_max_filesize = 100M" >> /usr/local/etc/php/php.ini

# Apache vhost
COPY docker/default.conf /etc/apache2/sites-enabled/000-default.conf

# Clear stale caches (may include dev-only providers) and ensure permissions
RUN rm -f bootstrap/cache/packages.php bootstrap/cache/services.php

# Set proper ownership
RUN chown -R www-data:www-data /var/www/html

CMD ["apache2-foreground"]

EXPOSE 80