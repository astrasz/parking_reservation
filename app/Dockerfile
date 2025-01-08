FROM php:8.3.7-fpm-alpine

WORKDIR /var/www

RUN apk add icu-dev 
RUN docker-php-ext-configure intl
RUN docker-php-ext-install pdo pdo_mysql intl
RUN docker-php-ext-enable intl

# ENV COMPOSER_ALLOW_SUPERUSER=1

COPY --from=composer:2.7 /usr/bin/composer /usr/bin/composer

COPY ../../app/composer.* ./

RUN composer install --prefer-dist --no-dev --no-scripts --no-progress --no-interaction

# COPY ../config/php/php.ini /usr/local/etc/php/

COPY ../../app .

# CMD ["php", "-S", "0.0.0.0:80", "-t", "public"]