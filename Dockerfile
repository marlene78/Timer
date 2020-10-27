#Installation de composer
FROM composer:latest AS composer

ENV CODE_DIR /code

WORKDIR $CODE_DIR

COPY ./composer.json $CODE_DIR/composer.json
COPY ./composer.lock $CODE_DIR/composer.lock
COPY ./src/ /code/src

RUN composer install \
        --ignore-platform-reqs \
        --no-ansi \
        --no-interaction \
        --prefer-dist \
        --no-progress \
        --no-suggest \
        --optimize-autoloader \
        --classmap-authoritative \
        --no-scripts \
        --quiet



#Installation de Php
FROM php:7.4.2-apache-buster

ENV PROJECT_DIR /var/www/project
ENV DOCUMENT_ROOT ${PROJECT_DIR}/public
ENV APP_ENV dev
ENV PORT 8082

WORKDIR $PROJECT_DIR

COPY --chown=www-data:www-data . $PROJECT_DIR
COPY --chown=www-data:www-data --from=composer /code/vendor $PROJECT_DIR/vendor


RUN docker-php-ext-install mysqli
RUN docker-php-ext-install pdo pdo_mysql
RUN docker-php-ext-install pdo_mysql

RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini" \
 && sed -i 's|variables_order = "GPCS"|variables_order = "EGPCS"|' $PHP_INI_DIR/php.ini \
 && a2enmod rewrite \
 && chown -R www-data ${PROJECT_DIR} \
 && sed -i "s|DocumentRoot /var/www/html|DocumentRoot ${DOCUMENT_ROOT}|" /etc/apache2/sites-available/000-default.conf \
 && echo "ServerName localhost" | tee /etc/apache2/conf-available/servername.conf && a2enconf servername

ENTRYPOINT []
CMD sed -i "s/80/$PORT/g" /etc/apache2/sites-enabled/000-default.conf /etc/apache2/ports.conf && docker-php-entrypoint apache2-foreground
