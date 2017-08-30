FROM php:7.1.8-apache

RUN docker-php-ext-install -j$(nproc) pdo pdo_mysql

RUN a2enmod rewrite

COPY . /var/www/html

RUN chmod -R -f 751 /var/www/html
RUN chown -R -f www-data /var/www/html
RUN chgrp -R -f www-data /var/www/html

ENV APACHE_RUN_USER www-data
ENV APACHE_RUN_GROUP www-data
ENV APACHE_LOG_DIR /var/log/apache2
ENV APACHE_LOCK_DIR /var/lock/apache2
ENV APACHE_PID_FILE /var/run/apache2.pid

COPY apache-config.conf /etc/apache2/sites-enabled/000-default.conf
CMD /usr/sbin/apache2ctl -D FOREGROUND
