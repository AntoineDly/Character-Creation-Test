# COMPOSER

## COMPOSER WITHOUT DEV DEPENDENCIIES FOR PROD
FROM composer:2.8.0 AS production_vendor_builder

WORKDIR /app

COPY composer.json composer.lock ./

RUN --mount=type=cache,target=/tmp/cache  composer install --no-ansi --no-interaction --no-scripts --no-dev --optimize-autoloader --prefer-dist

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

# INTERMEDIARY BUILD IMAGES

FROM base as build-ci-dev

RUN apk add --no-cache composer

# ----------------------------------------------------------------------------------------------------------------------------------------------- #

# FINAL BUILD IMAGES

## DEV IMAGE
FROM build-ci-dev AS dev

WORKDIR /var/www/html

COPY . .

RUN composer install

EXPOSE 8000

ENTRYPOINT ["/bin/sh", "-c", "./entrypoint.sh"]
