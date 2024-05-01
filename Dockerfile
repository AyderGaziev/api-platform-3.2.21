# Используем образ PHP с Apache
FROM php:7.4-apache

# Устанавливаем необходимые расширения PHP
RUN apt-get update && apt-get install -y \
    libicu-dev \
    zlib1g-dev \
    libzip-dev \
    && docker-php-ext-install \
    pdo_mysql \
    intl \
    zip

# Устанавливаем Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Копируем и устанавливаем приложение Symfony
COPY . /var/www/html
WORKDIR /var/www/html
RUN composer install --no-dev --optimize-autoloader

# Устанавливаем права доступа к каталогам для Apache
RUN chown -R www-data:www-data var

# Копируем файлы виртуального хоста Apache
COPY vhost.conf /etc/apache2/sites-available/000-default.conf

# Включаем модули Apache
RUN a2enmod rewrite