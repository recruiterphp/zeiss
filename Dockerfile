FROM php:7.3-alpine

RUN apk add git autoconf build-base gcc

RUN pecl install -f mongodb
RUN docker-php-ext-install -j$(nproc) pcntl
RUN docker-php-ext-enable mongodb

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" &&\
    php composer-setup.php &&\
    php -r "unlink('composer-setup.php');" && \
    mv composer.phar /usr/local/bin/composer

WORKDIR /app
