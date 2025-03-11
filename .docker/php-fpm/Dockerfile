FROM php:8.2-fpm-alpine

WORKDIR /var/www

ARG UID=1000
ARG GID=1000

RUN apk update && apk add --no-cache \
    build-base \
    autoconf \
    libtool \
    file \
    git \
    curl \
    libpng-dev \
    libjpeg-turbo-dev \
    libwebp-dev \
    libzip-dev \
    freetype-dev \
    imagemagick-dev \
    linux-headers \
    postgresql-dev \
    nodejs \
    npm \
    bash \
    vim \
    nano \
    tree \
    htop \
    shadow \
    # Runtime dependencies
    imagemagick \
    libpng \
    libjpeg-turbo \
    libwebp \
    libzip \
    freetype \
    openssl \
    && docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-install pdo pdo_mysql zip bcmath pcntl \
    && pecl install redis xdebug imagick swoole \
    && docker-php-ext-enable redis swoole imagick \
    && apk del --purge build-base autoconf libtool

# Modify www-data user and group
RUN usermod -u ${UID} www-data && groupmod -g ${GID} www-data

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY . /var/www
COPY ./.docker/php-fpm/php-dev.ini /usr/local/etc/php/conf.d/php.ini

RUN composer install --prefer-dist --no-scripts --no-progress --no-suggest --optimize-autoloader \
    && npm install --save-dev chokidar \
    && chown -R www-data:www-data /var/www \
    && chmod -R 775 /var/www/storage /var/www/bootstrap/cache

COPY ./.docker/php-fpm/start.sh /usr/local/bin/start.sh
RUN chmod +x /usr/local/bin/start.sh

USER www-data

CMD ["/usr/local/bin/start.sh"]
