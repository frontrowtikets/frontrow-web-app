FROM composer:2.8.2

ENV COMPOSERGROUP=frontrow
ENV COMPOSERUSER=frontrow

RUN adduser -g ${COMPOSERGROUP} -s /bin/sh -D ${COMPOSERUSER}

RUN apk add --no-cache libjpeg-turbo-dev libpng-dev

RUN docker-php-ext-configure exif

RUN docker-php-ext-install exif && docker-php-ext-enable exif