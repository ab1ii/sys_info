#jmt67 act web client container
#get os, webserver, php , yum, etc.
FROM centos:7

#
# Import the Centos-6 RPM GPG key to prevent warnings and Add EPEL Repository
#
RUN rpm --import http://mirror.centos.org/centos/RPM-GPG-KEY-CentOS-7 \
    && rpm --import http://dl.fedoraproject.org/pub/epel/RPM-GPG-KEY-EPEL-7 \
    && rpm -Uvh http://dl.fedoraproject.org/pub/epel/7/x86_64/Packages/e/epel-release-7-11.noarch.rpm \
	&& rpm -Uvh https://rpms.remirepo.net/enterprise/remi-release-7.rpm

RUN yum install epel-release \
    yum-config-manager --enablerepo remi-php56

RUN yum -y install \
    httpd \
    mod_ssl \
    php \
    php-cli \
    php-common \
    php-devel \
    php-gd \
    php-ldap \
    php-mbstring \
    php-mcrypt \
    php-pecl-memcached \
    php-xml \
    php-imap \
    php-soap \
    php-pear.noarch \
    php-opcache 
 


RUN yum update -y


EXPOSE 80


#copy source code
COPY app /var/www/html/
COPY startThings.sh /


CMD ./startThings.sh

