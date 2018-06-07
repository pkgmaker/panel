#!/bin/sh

sudo apt update;
sudo apt install -f;
sudo apt install -y nginx php-fpm php-odbc php-xml php-mysql php-curl php-mbstring curl php-cli mariadb-server;
sudo mysql -u root --password='' -e "update mysql.user set plugin = '' where User = 'root'";
sudo mysql -u root --password='' -e "SET PASSWORD FOR 'root'@'localhost' = PASSWORD('P455w0rd');FLUSH PRIVILEGES;";
sudo service mysql restart;
cd /var/www/html/panel;
rm -rf .git;
mysql -u root --password='P455w0rd' -e "create database panel";
cd panel;
wget https://getcomposer.org/composer.phar;
php composer.phar install;
mysql -u root --password='P455w0rd' panel < config/database.sql;
cp config/config.dist.php config/config.php
sudo cp config/nginx.server.cnf /etc/nginx/sites-available/default;
sudo /etc/init.d/php7.0-fpm restart;
sudo /etc/init.d/nginx restart;