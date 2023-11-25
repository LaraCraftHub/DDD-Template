ARG ALPINE_VERSION=3.18
ARG PHP_VERSION=8.2.11
ARG COMPOSER_VERSION=2.6.5
ARG EXTENSION_INSTALLER_VERSION=2.1.58

FROM composer/composer:$COMPOSER_VERSION-bin as composer
FROM mlocati/php-extension-installer:$EXTENSION_INSTALLER_VERSION as extension-installer
FROM php:$PHP_VERSION-fpm-alpine$ALPINE_VERSION

ARG DDTRACE_VERSION=0.92.2

LABEL maintainer="Abdelhamid Abouhassane <abdu.abou@gmail.com>"

# Required environment variables
ENV COMPOSER_ALLOW_SUPERUSER 1
ENV COMPOSER_HOME /tmp
ENV MUSL_LOCPATH /usr/share/i18n/locales/musl
ENV TZ Europe/Paris

# Add composer and extension-installer
COPY --from=composer /composer /usr/bin/composer
COPY --from=extension-installer /usr/bin/install-php-extensions /usr/local/bin/

# Add missing Alpine packages.
RUN apk add --no-cache \
    gettext \
    gnupg \
    nano \
    less \
    musl-locales \
    tzdata \
    cargo \
    xvfb-run;

# Install missing PHP extensions
RUN set -eux; \
    install-php-extensions \
    bcmath \
    ddtrace-${DDTRACE_VERSION} \
    exif \
    gd \
    gettext \
    imap \
    intl \
    mysqli \
    opcache \
    pcntl \
    pcov \
    pdo_mysql \
    pdo_pgsql \
    pgsql \
    redis \
    soap \
    sockets \
    xmlrpc \
    zip \
    && php -m;

# Configure locales, timezone, and php
RUN set -eux; \
    cp /usr/share/zoneinfo/$TZ /etc/localtime \
    && echo "$TZ" > /etc/timezone \
    && LC_ALL=fr_FR.UTF-8 date -d "1970-12-01" +%B | grep "Décembre" \
    && mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini" \
    && sed -i 's;access\.log = .*;access.log = /dev/null;' /usr/local/etc/php-fpm.d/docker.conf \
    && { echo 'memory_limit = 512M'; } | tee "$PHP_INI_DIR"/conf.d/zz-custom-memory.ini \
    && { echo 'expose_php = Off'; } | tee "$PHP_INI_DIR"/conf.d/zz-custom-expose.ini \
    && { echo "date.timezone = $TZ"; } | tee "$PHP_INI_DIR"/conf.d/zz-custom-timezone.ini \
    && php --ini;
