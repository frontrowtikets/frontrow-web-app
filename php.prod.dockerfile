FROM php:8.3.13-fpm-alpine

ENV PHPGROUP=frontrow
ENV PHPUSER=frontrow

RUN adduser -g ${PHPGROUP} -s /bin/sh -D ${PHPUSER}

RUN sed -i "s/user = www-data/user = ${PHPUSER}/g" /usr/local/etc/php-fpm.d/www.conf
RUN sed -i "s/group = www-data/group = ${PHPGROUP}/g" /usr/local/etc/php-fpm.d/www.conf

RUN mkdir -p /var/www/html/public

RUN set -ex \
    && apk --no-cache add \
    postgresql-dev

RUN docker-php-ext-install pdo pdo_pgsql

RUN docker-php-ext-install opcache

RUN apk add --no-cache libjpeg-turbo-dev libpng-dev

RUN docker-php-ext-configure exif

RUN docker-php-ext-install exif && docker-php-ext-enable exif

ADD opcache.ini /usr/local/etc/php/conf.d/opcache.ini

CMD ["php-fpm", "-y", "/usr/local/etc/php-fpm.conf", "-R"]