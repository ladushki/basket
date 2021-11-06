FROM php:8.0-apache

RUN apt-get -y update && apt-get -y install wget

RUN wget https://getcomposer.org/download/2.1.1/composer.phar

RUN chmod +x composer.phar

RUN mv composer.phar /bin/composer
