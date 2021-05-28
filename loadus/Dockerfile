FROM centos:7

RUN yum update -y
RUN yum -y install http://rpms.remirepo.net/enterprise/remi-release-7.rpm
RUN yum -y install epel-release yum-utils
RUN yum-config-manager --disable remi-php54
RUN yum-config-manager --enable remi-php73
RUN yum -y install php php-cli php-fpm php-mysqlnd php-zip php-devel php-gd php-mcrypt php-mbstring php-curl php-xml php-pear php-bcmath php-json apache2 wget unzip
RUN yum install -y git

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"

RUN php composer-setup.php --install-dir=/usr/local/bin --filename=composer

COPY . /var/www/html

COPY ./site.conf /etc/httpd/conf.d/

COPY .env.example /var/www/html/.env

WORKDIR /var/www/html

RUN composer install

RUN chmod -R 777 storage

EXPOSE 8080

cmd ["/usr/sbin/httpd", "-D", "FOREGROUND"]

