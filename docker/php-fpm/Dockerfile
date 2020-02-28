FROM php:7.4.3-fpm
RUN apt-get update && apt-get install -y autoconf build-essential
RUN apt-get install -y libcurl4-openssl-dev pkg-config libssl-dev
RUN pecl install mongodb \
    && pecl install apcu \
    && docker-php-ext-enable mongodb apcu