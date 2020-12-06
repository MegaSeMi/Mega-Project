FROM centos:7

RUN cp /usr/share/zoneinfo/Europe/Moscow /etc/localtime

RUN yum install -y \
        epel-release \
        http://rpms.remirepo.net/enterprise/remi-release-7.rpm \
        kernel kernel-devel yum-utils && \
    yum-config-manager --enable remi-php72 && \
    yum install -y \
        php-bcmath \
        php-cli \
        php-fpm \
        php-mysqlnd \
        php-xml \
        php-gd \
        php-mcrypt \
        php-memcached \
        php-ldap \
        php-imap \
        php-soap \
        php-tidy \
        php-mbstring \
        php-opcache \
        php-pdo \
        php-dom \
        php-process \
        php-pecl-xdebug \
        php-pecl-amqp \
        php-pecl-imagick \
        php-pecl-zip \
        unzip && \
    yum clean all -y

ADD etc/php.ini /etc/php.ini
ADD etc/php-fpm.conf /etc/php-fpm.conf
ADD etc/php-fpm.d/www.conf /etc/php-fpm.d/www.conf
ADD etc/php.d/15-xdebug.ini /etc/php.d/15-xdebug.ini

RUN mkdir -p /run/php-fpm
RUN mkdir -p /var/log/php-fpm

RUN ln -sf /dev/stderr /var/log/php-fpm/php-fpm.log

EXPOSE 9000 9001

ENTRYPOINT ["/usr/sbin/php-fpm", "-F", "-R"]
