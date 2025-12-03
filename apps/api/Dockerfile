# base image
FROM php:8.2-fpm


# system deps
RUN apt-get update && apt-get install -y \
git \
unzip \
libzip-dev \
zip \
libpng-dev \
libonig-dev \
libxml2-dev \
default-mysql-client \
curl \
&& docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip


# composer
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer


# workdir
WORKDIR /var/www/html


# copy and install
COPY . /var/www/html


RUN composer install --no-interaction --no-scripts --prefer-dist --no-progress --optimize-autoloader || true


# dev env: ensure storage and cache perms
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache || true


# expose port for php artisan serve (we map 8000 -> 8000 in compose)
EXPOSE 8000


# default command — use artisan serve for dev convenience
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]