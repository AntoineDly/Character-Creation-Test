# COMPOSER

## COMPOSER WITH DEV DEPENDENCIIES FOR DEV OR CI
FROM composer:2.8.0 AS not_production_vendor_builder

WORKDIR /app

COPY composer.json composer.lock ./

RUN composer install --no-ansi --no-interaction --no-scripts

## COMPOSER WITHOUT DEV DEPENDENCIIES FOR PROD
FROM composer:2.8.0 AS production_vendor_builder

WORKDIR /app

COPY composer.json composer.lock ./

RUN composer install --no-ansi --no-interaction --no-scripts --no-dev --optimize-autoloader

# ----------------------------------------------------------------------------------------------------------------------------------------------- #

# BASE

## BASE IMAGE FOR PHP
FROM alpine:3.22.2 AS base

ARG PHP_VERSION="82"

RUN apk update && apk add --no-cache \
    php${PHP_VERSION} \
    php${PHP_VERSION}-cli \
    php${PHP_VERSION}-tokenizer \
    php${PHP_VERSION}-mbstring \
    php${PHP_VERSION}-json \
    php${PHP_VERSION}-openssl \
    php${PHP_VERSION}-pdo \
    php${PHP_VERSION}-pdo_pgsql \
    php${PHP_VERSION}-pgsql \
    php${PHP_VERSION}-dom \
    php${PHP_VERSION}-session

# SYMBOLIC LINK TO EXECUTE PHP COMMANDS WITHOUT SPECIFYING PHP VERSION
RUN ln -sf /usr/bin/php${PHP_VERSION} /usr/bin/php

WORKDIR /app

# ----------------------------------------------------------------------------------------------------------------------------------------------- #

# FINAL BUILD IMAGES

## DEV IMAGE
FROM base AS dev

WORKDIR /var/www/html

COPY app app
COPY bootstrap bootstrap
COPY routes routes
COPY resources resources
COPY database database
COPY config config
COPY storage storage
COPY .env .env
COPY .env.example .env.example
COPY artisan artisan
COPY phpstan.neon phpstan.neon
COPY phpunit.xml phpunit.xml
COPY pint.json pint.json
COPY entrypoint.sh entrypoint.sh
COPY --from=not_production_vendor_builder /app/vendor vendor/

EXPOSE 8000

ENTRYPOINT ["/bin/sh", "-c", "./entrypoint.sh"]
