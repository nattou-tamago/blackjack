FROM php:8-apache

WORKDIR /var/www/html

RUN apt-get update \
    && apt-get install -y libonig-dev libzip-dev unzip \
    && docker-php-ext-install mbstring zip bcmath

COPY ./src /var/www/html
COPY ./docker/app/php.ini /usr/local/etc/php/php.ini
