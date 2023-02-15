FROM composer:2.0 as composer
# COPIA TUTTO  SU APP
COPY ./ /app
WORKDIR /app
# INSTALLA VERSIONE DI PHP
FROM php:8.1-fpm-alpine
ARG ENV="production"
# INSTALL ALL PACKAGE PHP, DOCKER, E MODIFICA IL PHP.INI
RUN apk add libstdc++ libxrender ttf-freefont --no-cache autoconf g++ make libzip-dev gcc pkgconfig imagemagick imagemagick-dev libgomp libpng-dev \
 && pecl install imagick \
 && rm -rf /tmp/pear \
 && cp /usr/local/etc/php/php.ini-production /usr/local/etc/php/php.ini \
 && sed -i "s/^expose_php = On/expose_php = Off/" /usr/local/etc/php/php.ini \
 && sed -i "s/upload_max_filesize = 2M/upload_max_filesize = 5M/" /usr/local/etc/php/php.ini \
 && sed -i "s/max_execution_time = 30/max_execution_time = 600/" /usr/local/etc/php/php.ini \
 && docker-php-ext-enable imagick \
 && docker-php-ext-install pdo_mysql \
 && apk del autoconf g++ make gcc
RUN apk --update add \
    wget \
    curl \
    build-base \
    libmcrypt-dev \
    libxml2-dev \
    pcre-dev \
    zlib-dev \
    autoconf \
    oniguruma-dev \
    openssl \
    openssl-dev \
    freetype-dev \
    libjpeg-turbo-dev \
    jpeg-dev \
    libpng-dev \
    imagemagick-dev \
    imagemagick \
    postgresql-dev \
    libzip-dev \
    gettext-dev \
    libxslt-dev \
    libgcrypt-dev &&\
    rm /var/cache/apk/*
RUN docker-php-ext-install zip
RUN docker-php-ext-configure gd
RUN docker-php-ext-install gd
RUN docker-php-ext-install \
    mysqli \
    mbstring \
    pdo \
    pdo_mysql \
    xml \
    pcntl \
    bcmath \
    pdo_pgsql \
    zip \
    intl \
    gettext \
    soap \
    sockets \
    xsl
# INSTALLA REDIS
RUN mkdir -p /usr/src/php/ext/redis \
    && curl -L https://github.com/phpredis/phpredis/archive/5.3.7.tar.gz | tar xvz -C /usr/src/php/ext/redis --strip 1 \
    && echo 'redis' >> /usr/src/php-available-exts \
    && docker-php-ext-install redis
RUN if [ "${http_proxy}" != "" ]; then \
    # Needed for pecl to succeed
    pear config-set http_proxy ${http_proxy} \
;fi
# DA TUTTI I PERMESSI DI SCRITTURA E LETTURA
RUN chmod 777 -R /var/www/html
RUN chown -R www-data:www-data /var/www
# Expose port 9000. SERVE PER PHP FPM
EXPOSE 9000
# Start php-fpm server.
CMD ["php-fpm"]
