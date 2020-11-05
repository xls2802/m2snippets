   ##PHP-CS-FIXER
### Некоторые предварительные условия :
  * PHPStorm установлен
  * Composer установлен и добавлен в путь ``$ export PATH="$PATH:$HOME/.composer/vendor/bin"``
  
  (получить путь к глобальному каталогу двоичных файлов ``composer global config bin-dir --absolute``)
  
  ##1. Установка PHP-CS-Fixer (варианты)
  
####1-1. Глобально (руками)
  ``$ wget https://cs.symfony.com/download/php-cs-fixer-v2.phar -O php-cs-fixer``
   ##### with specified version  
  ``$ wget https://github.com/FriendsOfPHP/PHP-CS-Fixer/releases/download/v2.15.8/php-cs-fixer.phar -O php-cs-fixer``
   ##### with CURL
  ``$ curl -L https://cs.symfony.com/download/php-cs-fixer-v2.phar -o php-cs-fixer``  
   #####  Then
  ``$ sudo chmod a+x php-cs-fixer``
  
  ``$ sudo mv php-cs-fixer /usr/local/bin/php-cs-fixer``  

####1-2. Глобально (через Composer)  
``$ composer global require friendsofphp/php-cs-fixer``

  или в специфическую директорию (если надо)
  
  ``$ mkdir --parents tools/php-cs-fixer``

  ``$ composer require --working-dir=tools/php-cs-fixer friendsofphp/php-cs-fixer``

####1-3. Глобально (через homebrew)
``$ brew install php-cs-fixer``

####1-4. Update
``$ php php-cs-fixer.phar self-update`` 


   ##2. Настройка PHP-CS-Fixer в PHPSTORM

#### 2-1. Открываем PHPStorm, Settings > Tools > External Tools  вводим следующие значения:
    Name:                       PHP CS-Fixer
    Program:                    /home/serj/.composer/vendor/friendsofphp/php-cs-fixer/php-cs-fixer
    Parameters (Arguments):     --rules=@PSR2 --verbose fix $FileDir$/$FileName$
    Working directory:          $ProjectFileDir$
 P.S. ("/home/serj/" нужно сменить на Вашу домашнюю директорию)
 
#### 2-2. Переходим в Settings -> Languages & Frameworks -> PHP -> Quality Tools:
   * Открываем вкладку PHP CS Fixer в правой части окна и кликаем на кнопке с многоточием справа от поля Configuration
   * В открывшемся окне нажимаем на иконке директории справа от поля PHP CS Fixer path и снова выбираем пусть к установленному на Вашей машине бинарному файлу php-cs-fixer. 
   Проверить, правилен ли путь, можно кнопкой Validate - внизу окна должно появиться соответствующее сообщение.
   ``/home/serj/.composer/vendor/friendsofphp/php-cs-fixer/php-cs-fixer``
   * Нажимаем Apply и потом Ok.
   
#### 2-3. "Поясняем", где находится файл кофиграции. 
   * Заходим в Settings -> Editor -> Inspections и отмечаем чекбокс PHP -> Quality Tools -> PHP CS Fixer validation
   * ставим галочку напротив Allow risky rules, кликаем на значок обновления справа от поля Ruleset и выбираем из списка Custom.
   (Это позволит указывать вручную настройки в файле ``.php_cs.dist`` в корне проекта)
   * Там же нажимаем на кнопку с многоточием. В открывшемся окне Custom Coding Standard выбираем путь к файлу .php_cs.dist в корне проекта.
   * Подтверждаем выбор нажав Ok и затем Apply
   
#### 2-4. Назначаем горячие клавиши   
   * Открываем Settings > Keymap 
   * Ищем по названию "PHP CS-Fixer" (ну или как Вы его назвали). 
   * Добавляем любое сочетание клавиш, например CTRL + WINDOWS

#### 2-5. Добавим в .gitignore файл .php_cs.cache. 
На данный момент такого файла в проекте не существует, но он будет создаваться после каждого запуска fixer-а.
"Тащить" его в репозиторий нет никакого смысла.

   ##3. Как использовать:
##### Для форматирования текущего файла используйте комбинацию горячих клавиш, которая была создана на предыдущем шаге.
##### Для форматирования всех файлов* проекта откройте консоль, перейдите в корень проекта и запустите команду php-cs-fixer fix. 
*Не будут отформатированы файлы, которые мы исключили в методах exclude и notPath в файле конфигурации .php_cs.dist