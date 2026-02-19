FROM php:7.4-fpm

WORKDIR /var/www/html

# System deps + PHP extensions for Laravel + Postgres + GD
RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        git \
        unzip \
        libpq-dev \
        libzip-dev \
        zip \
        libpng-dev \
        libjpeg-dev \
        libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_pgsql pgsql zip gd \
    && rm -rf /var/lib/apt/lists/*

# Composer (copied from official composer image)
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

CMD ["php-fpm"]
