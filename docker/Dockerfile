ARG PHP_VERSION=8.5-cli
FROM php:${PHP_VERSION}

RUN apt -y update && \
    apt install -y git libzip-dev zip

COPY --from=composer /usr/bin/composer /usr/bin/composer

WORKDIR /app