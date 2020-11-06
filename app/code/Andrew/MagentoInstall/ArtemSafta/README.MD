#Установка мадженты состоит из двух шагов:
	1 Скачать код;
	2 Скофигурировать систему и иницилизровать базу данных.;

#Скачать код можно такими путями:
	1 c помощью composer create project
	2 скачать архив с  magento.com
	3 склонировать magento 2 с репозитория на гихабе

#Чтобы Скофигурировать систему и иницилизровать базу данных мы можем воспользоваться двумя способами:
	Выполнить установку через браузер
	Выполнить установку с помощью команды  bin/magento setup:install ....

Пример комманды:
````
bin/magento setup:install --base-url=http://127.0.0.1/magento2/ \
--db-host=localhost --db-name=magento --db-user=magento --db-password=magento \
--language=en_US --currency=USD --timezone=America/Chicago --use-rewrites=1 \
--search-engine=elasticsearch7 --elasticsearch-host=es-host.example.com \
--elasticsearch-port=9200
````


Веб сервер может быть сконфигурирован по раазному. Может заходить index.php который находиться
в корне проэкта а может смотреть в папочку pub/index.php. Вариант с index.php в корне не такой безоопасаный.

Как быстро определить где нахоодиться точка входа.
Нужно посмотреть пути к статическим файлам. Если в путях есть папка pub, то есть DOCUMENT_ROOT находится в корне
Если сразу static то DOCUMENT_ROOT находиться в  pub.