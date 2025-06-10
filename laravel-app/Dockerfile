FROM php:8.2-fpm

# Instala libs e extensões comuns para Laravel 8
RUN apt-get update && apt-get install -y \
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

# Instalar Composer (pegando do container oficial do composer)
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Aumentar limite de memória para 512M
RUN echo "memory_limit=512M" > /usr/local/etc/php/conf.d/memory-limit.ini

WORKDIR /var/www/html

# Copiar só arquivos essenciais para cache do composer
COPY composer.json composer.lock ./
COPY .env.example ./.env

# Copiar o resto do código
COPY . .

# Instalar dependências PHP com composer (sem checar plataforma)
RUN composer install --ignore-platform-reqs --no-scripts --no-autoloader --no-progress --no-interaction

# Ajustar permissões - importante para Laravel
RUN chown -R www-data:www-data /var/www/html/.env /var/www/html/storage /var/www/html/bootstrap/cache
RUN chmod 664 /var/www/html/.env
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Rodar key generate e composer dump-autoload como www-data (mais seguro)
USER www-data

RUN php artisan key:generate

# Expor porta padrão do php-fpm
EXPOSE 9000

CMD ["php-fpm"]
