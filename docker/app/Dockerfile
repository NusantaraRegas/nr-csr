FROM php:7.4-fpm

WORKDIR /var/www/html

# System deps + PHP extensions for Laravel + Postgres
RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        git \
        unzip \
        libpq-dev \
        libzip-dev \
        zip \
    && docker-php-ext-install pdo pdo_pgsql pgsql zip \
    && rm -rf /var/lib/apt/lists/*

# Composer (copied from official composer image)
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Default user permissions (optional; kept simple)

CMD ["php-fpm"]

