FROM php:7.4-fpm
RUN apt-get update && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libicu-dev \
        libzip-dev \
        libonig-dev \
        wget \
        git \
        iputils-ping \
            --no-install-recommends
WORKDIR /app
