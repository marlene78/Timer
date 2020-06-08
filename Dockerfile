FROM php:7.4-fpm-alpine
RUN docker-php-ext-install mysqli
RUN docker-php-ext-install pdo pdo_mysql
RUN docker-php-ext-install pdo_mysql
