FROM php:7.3.25-apache

RUN docker-php-ext-install mysqli
RUN docker-php-ext-install pdo_mysql
#ZIP
RUN apt-get update && apt-get install -y \
    zlib1g-dev \
    libzip-dev \
    zip \
    wget
RUN docker-php-ext-install zip
#GD
RUN apt-get update && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
    && docker-php-ext-configure gd \
    && docker-php-ext-install -j$(nproc) gd

RUN docker-php-ext-install exif

RUN docker-php-ext-install fileinfo

RUN apt-get update && apt-get install -y libxml2-dev

RUN docker-php-ext-install xml

RUN docker-php-ext-install mbstring

RUN docker-php-ext-install json

# ioncube loader
COPY phpIonCube.sh /phpIonCube.sh
RUN chmod +x /phpIonCube.sh
RUN /bin/bash /phpIonCube.sh

RUN unzip /tmp/ioncube_loaders_* -d /tmp/
RUN  rm /tmp/ioncube_loaders_*.zip
RUN  ls -l /tmp
RUN  mkdir -p /usr/local/ioncube
RUN  cp /tmp/ioncube/ioncube_loader_* /usr/local/ioncube
RUN  rm -rf /tmp/ioncube

RUN echo "zend_extension = /usr/local/ioncube/ioncube_loader_lin_7.3.so" > /usr/local/etc/php/conf.d/docker-php-ext-iconcube.ini

#RUN mkdir -p /var/www/html/app/Config /var/www/html/app/tmp/cache /var/www/html/app/webroot/uploads /var/www/html/app/Locale
#RUN chown -R www-data:www-data /var/www/html/app/Config /var/www/html/app/tmp/cache /var/www/html/app/webroot/uploads /var/www/html/app/Locale

RUN a2enmod rewrite


