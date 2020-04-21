FROM debian

WORKDIR /var/www/vigrom

RUN apt-get update && \
    apt-get install  -y --force-yes \
        apt-transport-https \
        lsb-release \
        ca-certificates \
        wget \
        curl \
        git \
        unzip

RUN wget -O /etc/apt/trusted.gpg.d/php.gpg https://packages.sury.org/php/apt.gpg
RUN echo "deb https://packages.sury.org/php/ $(lsb_release -sc) main" > /etc/apt/sources.list.d/php.list

RUN apt-get update && \
    apt-get install -y --force-yes \
        php7.4 \
        php7.4-fpm \
        php7.4-zip \
        php7.4-gmp \
        php7.4-mbstring \
        php7.4-intl \
        php7.4-xml \
        php7.4-bcmath \
        php7.4-pgsql \
        php7.4-curl \
        php7.4-apcu \
        php-xdebug

RUN echo "xdebug.remote_enable=1" >> /etc/php/7.4/mods-available/xdebug.ini \
    && echo "xdebug.remote_autostart=1" >> /etc/php/7.4/mods-available/xdebug.ini \
    && echo "xdebug.remote_host=host.docker.internal" >> /etc/php/7.4/mods-available/xdebug.ini \
    && echo "xdebug.idekey=docker" >> /etc/php/7.4/mods-available/xdebug.ini

RUN apt-get install -y ca-certificates coreutils openssh-client git \
    && curl https://getcomposer.org/installer -o composer-setup.php \
    && curl https://composer.github.io/installer.sha384sum -o installer.sha384sum \
    && sha384sum installer.sha384sum \
    && php composer-setup.php --install-dir /usr/bin --filename=composer

COPY ./fpm-config/www.conf /etc/php/7.4/fpm/pool.d/

RUN mkdir -p /run/php

ENTRYPOINT ["php-fpm7.4", "-F"]