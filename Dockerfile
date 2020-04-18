FROM php:apache

WORKDIR /

# Composer
RUN apt-get -y update && apt-get -y upgrade
RUN apt-get -y install git
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install xdebug
#RUN pecl install xdebug
#RUN docker-php-ext-enable xdebug

# Other PHP7 Extensions

#RUN apt-get -y install libmcrypt-dev
# RUN docker-php-ext-install mcrypt

# RUN apt-get -y install libsqlite3-dev libsqlite3-0 #mysql-client
RUN docker-php-ext-install pdo_mysql 
RUN docker-php-ext-install mysqli

# Enable apache modules
RUN a2enmod rewrite headers

COPY composer.json /
RUN composer install