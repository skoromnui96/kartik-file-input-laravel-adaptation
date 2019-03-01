FROM php:7.3-fpm

RUN apt-get update && apt-get install -y libpq-dev

RUN apt-get update && \
    apt-get install -y libfreetype6-dev libjpeg62-turbo-dev && \
    docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ && \
    docker-php-ext-install gd

RUN docker-php-ext-install pdo pdo_mysql

USER root

WORKDIR /var/www/app