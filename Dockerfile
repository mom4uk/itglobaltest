FROM ubuntu:22.04

WORKDIR /app

ENV PORT=8000
ENV DEBIAN_FRONTEND=noninteractive
ENV TZ=Europe/Moscow
ENV PHP_VERSION=8.3

RUN apt-get update \
    && apt install software-properties-common -y \
    && add-apt-repository ppa:ondrej/php \
    && apt-get install -y \
    curl \
    make

COPY . .

RUN apt-get install -y \
    php${PHP_VERSION} \
    php${PHP_VERSION}-bcmath \
    php${PHP_VERSION}-exif \
    php${PHP_VERSION}-pdo \
    php${PHP_VERSION}-pgsql \
    php${PHP_VERSION}-pgsql \
    php${PHP_VERSION}-zip \
    php${PHP_VERSION}-xdebug \
    php${PHP_VERSION}-dom \
    php${PHP_VERSION}-xml \
    php${PHP_VERSION}-mbstring \
    php${PHP_VERSION}-sqlite3 \
    php${PHP_VERSION}-curl

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN composer install

CMD ["bash", "-c", "make db-prepare start-app"]

EXPOSE ${PORT}