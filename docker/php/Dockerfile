FROM php:8.4-fpm-alpine3.19

# Install dependency
RUN apk update && apk add --no-cache \
    git curl unzip zip bash shadow \
    icu-dev oniguruma-dev libxml2-dev libzip-dev \
    mysql-client mariadb-dev \
    libpng-dev freetype-dev libjpeg-turbo-dev libwebp-dev libxpm-dev \
    autoconf make g++ gcc musl-dev libtool pkgconf build-base

# Konfigurasi GD
RUN docker-php-ext-configure gd \
    --with-freetype \
    --with-jpeg \
    --with-webp \
    --with-xpm

# Install PHP extensions
RUN docker-php-ext-install -j$(nproc) \
    gd \
    pdo \
    pdo_mysql \
    mbstring \
    zip \
    exif \
    pcntl \
    bcmath \
    intl \
    soap \
    opcache

# Redis
RUN pecl channel-update pecl.php.net \
    && pecl install redis \
    && docker-php-ext-enable redis

# Bersihkan dependency build
RUN apk del \
    build-base autoconf make g++ gcc musl-dev libtool pkgconf \
    && rm -rf /tmp/pear /var/cache/apk/*

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www
