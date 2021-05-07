FROM php:7.4.18-fpm-alpine

RUN apk update \
    && apk add  --no-cache \
    bash \
    git \
    yarn \
    curl \
    icu-dev \
    libxml2-dev \
    g++ \
    make \
    autoconf \
    && docker-php-source extract \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug \
    && docker-php-source delete \
    && echo "zend_extension=$(find /usr/local/lib/php/extensions/ -name xdebug.so)" > /usr/local/etc/php/conf.d/xdebug.ini \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && apk del pcre-dev ${PHPIZE_DEPS} \
    && rm -rf /tmp/*

WORKDIR /var/www/project