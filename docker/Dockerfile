FROM php:8.2.3-cli-alpine

WORKDIR /app
COPY . /app

COPY --from=composer:2.5 /usr/bin/composer /usr/bin/composer
COPY ./docker/config.json /tmp/composer/config.json
ENV COMPOSER_HOME=/tmp/composer

COPY ./docker/.env.testing /app/.env

RUN composer install
RUN composer run test
