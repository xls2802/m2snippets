#!/bin/bash
# Ask the user for their name
magentoOwner="artem"
magentoTz="Europe/Kiev"
magentoLang="en_AU"
magentoCurr="AUD"
magentoDbHost="localhost"
magentoAdminLogin="admin"
magentoAdminPass="admin123"
magentoAdminEmail="admin@admin.com"

PHP=$(which php)
COMPOSER=$(which composer)

read -p 'Your site url: ' siteUrl
read -p 'Db Name: ' magentoDbName
read -p 'Db user: ' magentoDbUser
read -p 'Magento directory name: ' directoryName
read -sp 'Mysql Root Pass: ' mysqlPass
read -sp 'Db Password: ' magentoDbPass

configMysql(){
mysql -uroot -p${mysqlPass} <<MYSQL_SCRIPT
CREATE DATABASE ${magentoDbName};
CREATE USER '${magentoDbUser}'@'localhost' IDENTIFIED BY '${magentoDbPass}';
GRANT ALL PRIVILEGES ON ${magentoDbName}.* TO '${magentoDbUser}'@'localhost';
FLUSH PRIVILEGES;
MYSQL_SCRIPT
}

installMagento(){
mkdir $directoryName
sudo chown -R ${magentoOwner}:www-data $directoryName
cd $directoryName
git clone --depth 1 https://github.com/magento/magento2.git .
sudo find var generated vendor pub/static pub/media app/etc -type f -exec chmod g+w {} +
sudo find var generated vendor pub/static pub/media app/etc -type d -exec chmod g+ws {} +
sudo chown -R ${magentoOwner}:www-data .
sudo chmod u+x ./bin/magento
${COMPOSER} install

${PHP} ./bin/magento setup:install \
--base-url="http://${siteUrl}/" \
--db-host="${magentoDbHost}" \
--db-name="${magentoDbName}" \
--db-user="${magentoDbUser}" \
--db-password="${magentoDbPass}" \
--backend-frontname="admin" \
--admin-firstname="Admin" \
--admin-lastname="Admin" \
--admin-email="${magentoAdminEmail}" \
--admin-user="${magentoAdminLogin}" \
--admin-password="${magentoAdminPass}" \
--language="${magentoLang}" \
--currency="${magentoCurr}" \
--timezone="${magentoTz}" \
--use-rewrites=1
${PHP} ./bin/magento deploy:mode:set developer
}



doInstall(){
configMysql
installMagento
}

doInstall