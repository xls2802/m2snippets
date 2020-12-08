###Setup Script
#####Используются для создания изменения таблиц баз данных автоматическикогда модуль устанавливается.

#####Сетап скрипты исполняются после выполняется bin/magento setup:upgrade
#####Существуют такие типы сетап скриптов:

    InstallSchema выполняется один раз при первой установке модуля. Нвходится в папке Setup. Реализовывает InstallSchemaInterface.  Этот интерфейс ожидает реализации одного метода install.
	Принимаются два параметра SchemaSetupInterface $setup и ModuleContextInterface $context

	InstallData выполняется один раз при первой установке модуля реализовывает InstallDataInterface
	Ожидается реализация метода install.
	Этот класс отвечает за измение данных в таблицах

	UpgradeSchema выполняется каждый раз при изменение версии модуля
	реализовывает UpgradeSchemaInterface и метод upgrade
	UpgradeData выполняется каждый раз при изменение версии модуля реализовывает UpgradeDataInterface и метод upgrade

    Recurring реализовывает InstallSchemaInterface и метод install
	RecurringData реализовывает InstallDataInterface и метод  installData
	Выполняется каждый раз при запуске команды bin/magento setup:upgrade

	Uninstall скрипт реализовывает UninstallInterface
	выполняется при запуске команды bin/magento module:uninstall -remove-data Module_Name удаляет модуль установленный с помощью композера