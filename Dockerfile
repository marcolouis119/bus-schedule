FROM php:8.4.3-fpm

RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    unzip \
    curl \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd \
    && docker-php-ext-install zip \
    && docker-php-ext-install pdo pdo_mysql

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer

# Копирование проекта в контейнер
WORKDIR /var/www
COPY . .

# Установка зависимостей с помощью Composer
RUN composer install --no-interaction --prefer-dist

# Тут можно выбрать порт, который будет слушаться контейнером 
EXPOSE 8000

CMD ["php-fpm"]