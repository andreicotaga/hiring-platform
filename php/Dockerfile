FROM --platform=linux/amd64 php:8.1-fpm

ENV PANTHER_NO_SANDBOX 1
ENV PANTHER_CHROME_ARGUMENTS='--disable-dev-shm-usage'

RUN apt update \
    && apt install -y zlib1g-dev g++ git libicu-dev zip libzip-dev zip wget xvfb unzip gnupg libxi6 libgconf-2-4 \
    && docker-php-ext-install intl opcache pdo pdo_mysql \
    && pecl install apcu \
    && docker-php-ext-enable apcu \
    && docker-php-ext-configure zip \
    && docker-php-ext-install zip \
    && docker-php-ext-enable pdo_mysql

RUN apt-get install -y nodejs npm

WORKDIR /var/www/hiring-platform

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN curl -sS https://get.symfony.com/cli/installer | bash
RUN git config --global user.email "andrei.cotaga1@gmail.com" \
    && git config --global user.name "Andrei Cotaga"
