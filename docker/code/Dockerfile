FROM centos AS build

# install php dependencies
RUN yum install php70u-json && yum install ea-php74-php-iconv && yum install php-pecl-memcache


#install git
RUN yum install -y git

WORKDIR /var/www
# clone repo
RUN git clone https://github.com/romanady/showcase.git showcase

# download composer
FROM php:7.4.1-fpm
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# run composer install
RUN composer install



