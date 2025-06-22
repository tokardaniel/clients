FROM composer/composer:2.8

WORKDIR /build

ADD . .

RUN composer install --no-dev --no-interaction --optimize-autoloader

FROM php:8.4.8-apache

RUN apt update -y && apt install -y netcat-traditional

ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf
RUN a2enmod rewrite headers

RUN /usr/local/bin/docker-php-ext-install pdo pdo_mysql

COPY --from=0 /build /var/www/html

RUN chmod -R 777 /var/www/html/storage \
    && chmod -R 777 /var/www/html/bootstrap/cache \
    && chmod -R 777 /var/www/html/database

RUN chmod +x /var/www/html/entrypoint.sh

ENTRYPOINT ["/var/www/html/entrypoint.sh"]
CMD ["apache2-foreground"]
