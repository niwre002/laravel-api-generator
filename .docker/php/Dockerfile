FROM ubuntu:bionic

#disable interactivity
ENV DEBIAN_FRONTEND=noninteractive

RUN apt-get update && apt-get install -y \
#enable make
build-essential \
#enable add repository
software-properties-common

RUN apt-get update && \
apt-get install -y supervisor
RUN add-apt-repository ppa:ondrej/php

RUN apt-get update && apt-get install -yq --no-install-recommends \
    apt-utils \
    curl \
    # Install git
    git \
    # Install apache
    apache2 \
    # Install php 8.1
    php8.1 \
    php8.1-dev \
    php8.1-mongodb \
    php8.1-cli \
    php8.1-curl \
    php8.1-fpm \
    php8.1-gd \
    php8.1-mbstring \
    php8.1-mysql \
    php8.1-xml \
    php8.1-zip \
    php8.1-intl \
    libapache2-mod-php8.1 \
    # Install tools
    openssl \
    sudo \
    nano \
    mysql-client \
    && apt-get clean && rm -rf /var/lib/apt/lists/* 

RUN apt-get update && \
apt-get install -y php-pear libcurl3-openssl-dev

RUN a2enmod rewrite

EXPOSE 80

ENV APACHE_RUN_USER www-data
ENV APACHE_RUN_GROUP www-data
ENV APACHE_LOG_DIR /var/log/apache2
ENV APACHE_LOCK_DIR /var/lock/apache2
ENV APACHE_PID_FILE /var/run/apache2.pid

RUN apt-get update && apt-get -y install default-jre unzip wget

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer --version

RUN echo "extension=mongodb.so" >> /etc/php/8.1/apache2/php.ini
CMD /usr/sbin/apache2ctl -D FOREGROUND

RUN touch /etc/sudoers.d/www-data && \
echo  "www-data ALL=NOPASSWD: /usr/bin/unoconv" >> /etc/sudoers.d/www-data

# Setup cron job
RUN pecl install mongodb

# Run the command on container startup
#CMD cron && tail -f /var/log/cron.log

COPY ./vhost.conf /etc/apache2/sites-available/000-default.conf

USER root
WORKDIR /var/www/html/