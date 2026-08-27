FROM composer:2.6.6
WORKDIR /app
COPY . .
COPY custom.ini /usr/local/etc/php/conf.d/
RUN composer install && docker-php-ext-install mysqli pdo_mysql
ENTRYPOINT ["php", "-S", "0.0.0.0:3000"]
