ARG PHP_VERSION=8.4
FROM php:${PHP_VERSION}-bullseye

RUN apt -y update && \
    apt install -y git libzip-dev zip

COPY --from=composer /usr/bin/composer /usr/bin/composer

WORKDIR /app