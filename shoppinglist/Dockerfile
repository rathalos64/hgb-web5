FROM php:apache

COPY ./www /var/www/html

RUN docker-php-ext-install pdo pdo_mysql
RUN a2enmod rewrite