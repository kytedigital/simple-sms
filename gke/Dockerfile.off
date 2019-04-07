FROM php:7.3-apache

WORKDIR /var/www/html

COPY --chown=www-data:www-data . /var/www/html

COPY apache.conf /etc/apache2/sites-available/000-default.conf

# Use the default production configuration
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"
COPY php.ini $PHP_INI_DIR/conf.d/app.ini

RUN apt-get update && apt-get install -y \
    build-essential \
    mysql-client \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    libzip-dev \
    zip \
    unzip \
    git \
    curl

RUN pecl install redis
RUN docker-php-ext-enable redis
RUN docker-php-ext-install pdo_mysql mbstring zip exif pcntl bcmath

RUN a2enmod rewrite

EXPOSE 80