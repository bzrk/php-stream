FROM php:8.2-bullseye

RUN apt -y update && \
    apt install -y git libzip-dev zip

COPY --from=composer /usr/bin/composer /usr/bin/composer

WORKDIR /app