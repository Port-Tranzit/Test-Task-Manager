FROM php:8-fpm-alpine

RUN curl -s https://getcomposer.org/installer | php
RUN mv composer.phar /usr/local/bin/composer

RUN docker-php-ext-install pdo pdo_mysql

RUN apk add --no-cache \
  libjpeg-turbo-dev \
  libpng-dev \
  libwebp-dev \
  freetype-dev

RUN docker-php-ext-install gd

RUN echo 'memory_limit = 2048M' >> /usr/local/etc/php/conf.d/docker-php-memlimit.ini

WORKDIR /var/www/html
