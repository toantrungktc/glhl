FROM php:7.4-fpm

LABEL MAINTAINER nguyentoantrung@gmail.com

# Env variables
ENV ACCEPT_EULA=y

# Install selected extensions and other stuff
RUN apt-get update \
    && apt-get -y --no-install-recommends install apt-utils libxml2-dev gnupg apt-transport-https \
    && apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

# Install git
RUN apt-get update \
    && apt-get -y install git \
    && apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

#Install ODBC Driver
RUN curl https://packages.microsoft.com/keys/microsoft.asc | apt-key add - \
    && curl https://packages.microsoft.com/config/debian/9/prod.list > /etc/apt/sources.list.d/mssql-release.list \
    && apt-get update

# Install sqlsrv
RUN apt-get update
RUN apt-get install -y wget
RUN wget http://ftp.br.debian.org/debian/pool/main/g/glibc/multiarch-support_2.24-11+deb9u4_amd64.deb && \
    dpkg -i multiarch-support_2.24-11+deb9u4_amd64.deb
RUN apt-get -y install msodbcsql17 unixodbc-dev
RUN pecl install sqlsrv pdo_sqlsrv

# Install webapp extension
RUN apt-get update && \
    apt-get install -y \
    git libzip-dev libicu-dev\
    && docker-php-ext-install zip
RUN docker-php-ext-install intl mysqli pdo pdo_mysql \
    && docker-php-ext-enable sqlsrv pdo_sqlsrv

RUN chown -R www-data:www-data /var/www


# RUN addgroup -g 1000 -S www && \
#     adduser -u 1000 -S www -G www

# #USER root

# COPY --chown=www:www-data . /var/www

# RUN chown -R www:www-data /var/www/storage
# RUN chmod -R ug+w /var/www/storage