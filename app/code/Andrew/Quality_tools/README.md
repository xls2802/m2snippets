# Code Sniffer
###Установка
Это один один из инструментов для повышения качества написанного кода.  

Этот инструмент поможет выявить нарушения форматирования, при надлежащей настройке PhpStorm будет об этом информировать путём выделения проблемных частей кода. Кроме всего прочего мы можем воспользоваться консолью для вывода информации об ошибках.

Для установки необходимо использовать композер:
```
composer require "squizlabs/php_codesniffer=*"  --dev
```

После этого доступны 2 команды в консоли для проверки на ошибки форматирования и дальнейшего фикса кода.
```
./vendor/bin/phpcs
./vendor/bin/phpcbf
```

Для установки правил проверки кода для проектов на Магенте 2 необходимо установить кастомные магентовские рулы:
```
composer require --dev magento/magento-coding-standard
```

После этого можно инспектировать код используя магентовские рулы. Например:

```
vendor/bin/phpcs --standard=Magento2 app/code/
```

Если будут проблемы с обнаружением правил для magento 2 нужно добавить конфигурацию
```
vendor/bin/phpcs --config-set installed_paths ./vendor/magento/magento-coding-standard/
```

И после этого автоматически править код, если есть ошибки:
```
vendor/bin/phpcbf --standard=Magento2 app/code/
```

###Интеграция в PhpStorm

- Идем на Preferences -> Languages & Frameworks -> PHP -> CodeSniffer
- Выбираем путь к файлу phpcs и phpcbf
- Заходим в Preferences -> Editor -> Inspections -> PHP -> Quality Tools -> PHP Code Sniffer validation для установки правил проверки кода
- Ставим галочку напротив PHP Code Sniffer validation
- Выбираем Coding standart: Custom
- Указываем путь к рулам Магенты: ./vendor/magento/magento-coding-standard/ruleset.xml



#PHP Mess Detector 
Mess Detector (обнаружитель беспорядков), будучи установленным, обрабатывает ваш код утилитой ````PHP_Depend```` и использует полученные метрики для составления собственных отчётов.

````PHPMD```` пытается выявить ошибки, которые не находит компилятор, не оптимальные алгоритмы, переусложнённый код, не используемые выражения и другие подобные проблемы.

В magento 2 присутствует в дев зависимостях. Настроить очень легко.
Заходим в Settings (ctrl+alt+s) ->  Languages & framework -> Php -> Quality tools
Дальше в конфигурации указываем путь /var/www/magento.loc/vendor/bin/phpmd. Зачастую сам подтягивается
Жмем Apply, Save.


# PhpStan

PHPStan – это инструмент сатического анализа (что и зачем -> https://ru.wikipedia.org/wiki/Статический_анализ_кода ) кода PHP. PHPStan – читает код и PHPDoc и пытаеться обнаружить потенциальные проблемы, такие как:

- вызов неопределенных переменных
- передача неверных типов данных
- использование несуществующих методов и атрибутов
- передача неверного количества параметов в метод
- использование возможных нулевых указателей

Устанавливается через composer:
```
composer require --dev phpstan/phpstan
```

В корень проекта добавляем корневой конфиг файл phpstan.neon:
```
parameters:
includes:
    - vendor/bitexpert/phpstan-magento/extension.neon
    - app/code/Itdelight/Callback/extension.neon
```

В каждый модуль добавляем файл extension.neon с кастомными настройками валидатора. Например, для модуля app/code/Itdelight/Callback/extension.neon:
```
parameters:
    level: 7
    fileExtensions:
        - php
        - phtml
    paths:
        - ./
    checkMissingIterableValueType: false
```

Запускаем с консоли:
```
./vendor/bin/phpstan analyse
```

   ## PHP-CS-FIXER
### Некоторые предварительные условия :
  * PHPStorm установлен
  * Composer установлен и добавлен в путь ``$ export PATH="$PATH:$HOME/.composer/vendor/bin"``
  
  (получить путь к глобальному каталогу двоичных файлов ``composer global config bin-dir --absolute``)
  
  ## 1. Установка PHP-CS-Fixer (варианты)
  
#### 1-1. Глобально (руками)
  ``$ wget https://cs.symfony.com/download/php-cs-fixer-v2.phar -O php-cs-fixer``
   ##### with specified version  
  ``$ wget https://github.com/FriendsOfPHP/PHP-CS-Fixer/releases/download/v2.15.8/php-cs-fixer.phar -O php-cs-fixer``
   ##### with CURL
  ``$ curl -L https://cs.symfony.com/download/php-cs-fixer-v2.phar -o php-cs-fixer``  
   #####  Then
  ``$ sudo chmod a+x php-cs-fixer``
  
  ``$ sudo mv php-cs-fixer /usr/local/bin/php-cs-fixer``  

#### 1-2. Глобально (через Composer)  
``$ composer global require friendsofphp/php-cs-fixer``

  или в специфическую директорию (если надо)
  
  ``$ mkdir --parents tools/php-cs-fixer``

  ``$ composer require --working-dir=tools/php-cs-fixer friendsofphp/php-cs-fixer``

#### 1-3. Глобально (через homebrew)
``$ brew install php-cs-fixer``

#### 1-4. Update
``$ php php-cs-fixer.phar self-update`` 


   ## 2. Настройка PHP-CS-Fixer в PHPSTORM

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

#### 2-6. В корне проекта создаем файл .php_cs.dist, куда помещаем следующий код:
```
<?php

$finder = PhpCsFixer\Finder::create()
    ->exclude(['bootstrap', 'node_modules', 'public', 'storage', 'vendor'])
    ->notPath('*')
    ->in(__DIR__);

return PhpCsFixer\Config::create()
    ->setRiskyAllowed(true)
    ->setRules([
        '@PSR2' => true,
        'array_syntax' => ['syntax' => 'short'],
        'binary_operator_spaces' => true,
        'blank_line_after_namespace' => true,
        'blank_line_after_opening_tag' => true,
        'blank_line_before_return' => true,
        'braces' => true,
        'cast_spaces' => true,
        'class_attributes_separation' => true,
        'class_definition' => true,
        'concat_space' => ['spacing' => 'none'],
        'declare_equal_normalize' => ['space' => 'none'],
        'elseif' => true,
        'encoding' => true,
        'full_opening_tag' => true,
        'function_declaration' => ['closure_function_spacing' => 'one'],
        'function_typehint_space' => true,
        'heredoc_to_nowdoc' => true,
        'include' => true,
        'increment_style' => ['style' => 'post'],
        'linebreak_after_opening_tag' => true,
        'list_syntax' => ['syntax' => 'short'],
        'lowercase_cast' => true,
        'lowercase_constants' => true,
        'lowercase_keywords' => true,
        'lowercase_static_reference' => true,
        'magic_constant_casing' => true,
        'magic_method_casing' => true,
        'method_argument_space' => true,
        'multiline_whitespace_before_semicolons' => ['strategy' => 'no_multi_line'],
        'native_function_casing' => true,
        'no_blank_lines_after_class_opening' => true,
        'no_blank_lines_after_phpdoc' => true,
        'no_closing_tag' => true,
        'no_empty_phpdoc' => true,
        'no_empty_statement' => true,
        'no_extra_blank_lines' => true,
        'no_leading_import_slash' => true,
        'no_leading_namespace_whitespace' => true,
        'no_mixed_echo_print' => true,
        'no_multiline_whitespace_around_double_arrow' => true,
        'no_short_bool_cast' => true,
        'no_singleline_whitespace_before_semicolons' => true,
        'no_spaces_after_function_name' => true,
        'no_spaces_around_offset' => true,
        'no_spaces_inside_parenthesis' => true,
        'no_trailing_comma_in_list_call' => true,
        'no_trailing_comma_in_singleline_array' => true,
        'no_trailing_whitespace' => true,
        'no_trailing_whitespace_in_comment' => true,
        'no_unneeded_control_parentheses' => true,
        'no_unused_imports' => true,
        'no_useless_else' => true,
        'no_useless_return' => true,
        'no_whitespace_before_comma_in_array' => true,
        'no_whitespace_in_blank_line' => true,
        'normalize_index_brace' => true,
        'object_operator_without_whitespace' => true,
        'ordered_imports' => ['sort_algorithm' => 'length'],
        'php_unit_fqcn_annotation' => true,
        'phpdoc_align' => ['align' => 'vertical'],
        'phpdoc_indent' => true,
        'phpdoc_inline_tag' => true,
        'phpdoc_no_access' => true,
        'phpdoc_no_package' => true,
        'phpdoc_no_useless_inheritdoc' => true,
        'phpdoc_order' => true,
        'phpdoc_scalar' => true,
        'phpdoc_separation' => true,
        'phpdoc_single_line_var_spacing' => true,
        'phpdoc_summary' => true,
        'phpdoc_to_comment' => true,
        'phpdoc_trim' => true,
        'phpdoc_types' => true,
        'phpdoc_var_without_name' => true,
        'psr4' => true,
        'self_accessor' => true,
        'short_scalar_cast' => true,
        'simplified_null_return' => true,
        'single_blank_line_at_eof' => true,
        'single_blank_line_before_namespace' => true,
        'single_class_element_per_statement' => true,
        'single_import_per_statement' => true,
        'single_line_after_imports' => true,
        'single_quote' => true,
        'space_after_semicolon' => true,
        'standardize_not_equals' => true,
        'switch_case_semicolon_to_colon' => true,
        'switch_case_space' => true,
        'ternary_operator_spaces' => true,
        'trailing_comma_in_multiline_array' => true,
        'trim_array_spaces' => true,
        'unary_operator_spaces' => false,
        'visibility_required' => true,
        'whitespace_after_comma_in_array' => true,
    ])
    ->setFinder($finder);
```


   ##3. Как использовать:
##### Для форматирования текущего файла используйте комбинацию горячих клавиш, которая была создана на предыдущем шаге.
##### Для форматирования всех файлов* проекта откройте консоль, перейдите в корень проекта и запустите команду php-cs-fixer fix. 
*Не будут отформатированы файлы, которые мы исключили в методах exclude и notPath в файле конфигурации .php_cs.dist

#Pre-commit hook
Добавляем файл pre-commit в папку .git/hooks/

Указываем абсолютный или относительный путь к code sniffer и phpstan.

После это во время коммита в Phpstorm будет чекбокс Run git hooks. 
Он должен быть включенным. 
Будет производится проверка статическим анализатором

#Magento Cache Clean

Утилита которая позволяет  позволяет более быстро сбрасывать кэш и наблюдать изменения в файлах 

Установака

````composer require --dev mage2tv/magento-cache-clean````

Запускаем с помощью команды

````/usr/bin/node /home/artem/.composer/vendor/bin/cache-clean.js -w```` 

Можно использовать hot keys.


|Key|Cache Segment(s)|
|---|----------------|
|`c`| `config` |
|`b`| `block_html` |
|`l`| `layout` |
|`f`| `full_page` |
|`a`| (a for all) |
|`v`| (v for view) `block_html`, `layout`, `full_page` |
|`t`| `translate` |

Для того чтобы они работали в Phpstorm нажимаем Ctrl + Shift + a

Вводим ````registry````. 
В списке выбираем ````Registry...````

Включаем чекбокс ````nodejs.console.use.terminal````

Запуск скрипта из Phpstorm
````Settings->Tools````

Дальше Жмём на плюсик.

Выбираем `node.js`

Называем, например `cache-cleaner`

Указываем `Javascript file` - `vendor/bin/cache-cleaner.js`

`Application parametr` - `-w`

Теперь в правом верхнем углу как для xdebug мы увидим наш скрипт и сможем его запустить

 





    