FROM php:8.2-fpm

# Instala libs e extensões comuns para Laravel 8
RUN apt-get update && apt-get install -y \
    libsqlite3-dev \
    iproute2 \
    libpq-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    curl \
    libonig-dev \
    autoconf \
    build-essential \
    && docker-php-ext-install pdo pdo_pgsql pgsql zip mbstring bcmath opcache

# Instalar Xdebug via PECL
RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

RUN docker-php-ext-install pdo pdo_sqlite

# Configurações do Xdebug
RUN echo "zend_extension=xdebug.so" > /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.mode=debug" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.start_with_request=yes" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.discover_client_host=true" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.client_host=172.17.0.1" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.client_port=9003" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

# Instalar Composer (pegando do container oficial do composer)
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Aumentar limite de memória para 512M
RUN echo "memory_limit=512M" > /usr/local/etc/php/conf.d/memory-limit.ini

WORKDIR /var/www/laravel-app

# Copiar só arquivos essenciais para cache do composer
COPY composer.json composer.lock ./
COPY .env.example ./.env

# Copiar o resto do código
COPY . .

# Instalar dependências PHP com composer
RUN composer install --ignore-platform-reqs --no-scripts --no-autoloader --no-progress --no-interaction

#RUN php artisan key:generate

# RUN php artisan config:clear
# RUN php artisan cache:clear
# RUN php artisan route:clear
# RUN php artisan view:clear

EXPOSE 9000 9003

CMD ["php-fpm"]
