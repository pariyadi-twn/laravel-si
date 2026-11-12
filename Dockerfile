FROM php:8.4-fpm

RUN apt-get update \
    && apt-get install -y \
       git curl ca-certificates zip unzip \
       libicu-dev libonig-dev libzip-dev \
       libpng-dev libjpeg62-turbo-dev libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-configure intl \
    && docker-php-ext-install pdo \
       pdo_mysql mbstring xml bcmath intl zip gd exif opcache \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . .

EXPOSE 9000

CMD ["php-fpm"]