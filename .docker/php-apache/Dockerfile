FROM php:8.1.0-apache
COPY . /var/www/html
COPY ./.docker/php-apache/000-default.conf /etc/apache2/sites-available/000-default.conf
COPY ./.docker/php-apache/php.ini-development /usr/local/etc/php/php.ini-development
COPY ./.docker/php-apache/php.ini-production /usr/local/etc/php/php.ini-production
RUN apt-get update
RUN docker-php-ext-install pdo_mysql
RUN a2enmod rewrite

RUN apt-get update && apt-get -y --no-install-recommends install git
RUN curl -sS https://getcomposer.org/installer | \
php -- --install-dir=/usr/local/bin --filename=composer
