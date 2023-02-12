FROM php:8.1-apache as rr_install

# PHP Extensions
RUN apt-get update \
    && apt-get install -y wget \
        apt-transport-https \
        libfreetype6 \
        libfontconfig \
        libssl-dev \
        libmcrypt-dev \
        libxml2-dev \
        libzip-dev \
        libpng-dev \
        git \
        zip \
        zip \
    && rm -rf /var/lib/apt/lists/* \
    && apt-get autoremove -y

RUN docker-php-ext-install pdo pdo_mysql bcmath xml pcntl zip soap gd

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# PHANTOM JS INSTALLATION
RUN wget -q https://bitbucket.org/ariya/phantomjs/downloads/phantomjs-1.9.7-linux-x86_64.tar.bz2
RUN tar xjf phantomjs-1.9.7-linux-x86_64.tar.bz2
RUN install -t /usr/local/bin phantomjs-1.9.7-linux-x86_64/bin/phantomjs
RUN rm -rf phantomjs-1.9.7-linux-x86_64
RUN rm phantomjs-1.9.7-linux-x86_64.tar.bz2

# PECL Install
RUN pecl install mongodb xdebug mcrypt \
    && echo "extension=mongodb.so" > $PHP_INI_DIR/conf.d/mongo.ini

FROM rr_install AS rr_app

RUN docker-php-ext-enable mongodb xdebug mcrypt bcmath mcrypt pcntl pdo_mysql sodium zip
RUN a2enmod rewrite headers
RUN cd /usr/local/etc/php/conf.d/ && \
    echo 'memory_limit = -1' >> /usr/local/etc/php/conf.d/docker-php-memlimit.ini
    
COPY ./vhost.conf /etc/apache2/sites-available/000-default.conf
