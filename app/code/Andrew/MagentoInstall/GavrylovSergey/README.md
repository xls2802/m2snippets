# УСТАНОВКА Magento (этапы)
1) Скачивание кода 
2) Развертывание базы данных

# Скачивание кода (варианты):
  * Через composer; 
  ``sudo apt install composer``
  * Скачивание ZIP архива c https://magento.com/ (Community -> Get Open Source -> Download Open Source) 
  * Клонирование репозитория. 
  
# Развертывание базы (варианты):
  * webvisor
  *  через командную строку
  
  
  #1. Установка PHP и требуемых расщирений
  ``sudo apt install libapache2-mod-php7.4 \
    php7.4 \
    php7.4-bcmath \
    php7.4-bz2 \
    php7.4-common \
    php7.4-curl \
    php7.4-dba \
    php7.4-enchant \
    php7.4-gd \
    php7.4-gmp \
    php7.4-imap \
    php7.4-interbase \
    php7.4-intl \
    php7.4-json \
    php7.4-ldap \
    php7.4-mbstring \
    php7.4-mysql \
    php7.4-odbc \
    php7.4-opcache \
    php7.4-pgsql \
    php7.4-phpdbg \
    php7.4-pspell \
    php7.4-readline \
    php7.4-soap \
    php7.4-sqlite3 \
    php7.4-sybase \
    php7.4-tidy \
    php7.4-xml \
    php7.4-xmlrpc \
    php7.4-xsl \
    php7.4-zip \
    php7.4-dev \
    php7.4-fpm \
    php7.4-exif \
    php7.4-gettext \
    php7.4-mysqli \
    php7.4-xdebug \
    php-imagick
``
  #2. PHP ON/OFF
 #включить пхп 7.4
 `` #!/bin/bash
  sudo a2dismod php7.2
  sudo a2dismod php7.4
  sudo a2enmod php7.4
  sudo service apache2 restart
  sudo update-alternatives --set php /usr/bin/php7.4``
  
  #3. ELASTICSEARCH
  * Download  https://artifacts.elastic.co/downloads/elasticsearch/elasticsearch-7.6.2-amd64.deb
  * Install
  * Install JDK 
  
  ```(sudo apt search jdk)  sudo apt install openjdk-8-jdk-headless```
  
  * Стартуем Эластик 
  ``sudo service elasticsearch start``

  * Проверяем ``curl http://127.0.0.1:9200``

  #4. COMPOSER STEPS
 #community
 ``create-project --repository-url=https://repo.magento.com/ magento/project-community-edition <install-directory-name>``
  
 #enterprise
 ``composer create-project --repository-url=https://repo.magento.com/ magento/project-enterprise-edition <install-directory-name>``

 #5. Развертываем базу (указать свои логины и пароли)
 ``bin/magento setup:install --backend-frontname="admin" --session-save="files" --db-host="localhost" --db-name="m24" --db-user="name" --db-password="pass" --base-url="http://m24.loc/" --base-url-secure="https://m24.loc/" --admin-user="adminName" --admin-password="adminPass" --admin-email="test@example.com" --admin-firstname="Admin" --admin-lastname="Admin" --key="SYrHBYGFRk5eEkmcpqGF43UhdUTAGdPX"`` 
 
 #6. (опционально) SAMPLE DATA download 
 ``$ bin/magento sampledata:deploy``
 
 ``$ bin/magento setup:upgrade``

 #7. Завешение (копмиляция кода и статики)
``php bin/magento setup:upgrade``

``php bin/magento setup:di:compile``

``php bin/magento setup:static-content:deploy``


#8 права 
    cd /var/www/html/magento2 && find var generated vendor pub/static pub/media app/etc -type f -exec chmod u+w {} + && find var generated vendor pub/static pub/media app/etc -type d -exec chmod u+w {} + && chmod u+x bin/magento



