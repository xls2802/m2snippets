### Режимы работы.

Для того чтобы проверить в каком режиме сейчас работате Магенто необходимо ввести команду:

```
php bin/magento deploy:mode:show
```

Для того чтобы изменить режим работы Магенто необходимо ввести команду, например:
```
php bin/magento deploy:mode:set developer
```

Есть 3 режима работы:

<ol>
<li>Default

Это комбинция developer и production. Этот спосб работы будет исключен из Магенто в дальнейшем.

Особенности работы:
<ul>
<li>
Ошибки не выводятся пользователю. Они логируются.
</li>
<li>
Статические файлы создаются и кэшируются.
</li>
<li>
Создаются сиимлинки на статические файлы в папке pub/static.
</li>
</ul>

</li>
<li>Developer

Предназначен для решения задач разработчика.
Особенности работы:
<ul>
<li>
Ошибки и стэк-трейс выводятся пользователю.
</li>
<li>
XML файлы все время валидируются по своим схемам.
</li>
<li>
Статические файлы создаются при каждом запросе.
</li>
<li>
X-Magento-* дэбаг-хэдэры всегда добавляются в ответ.
</li>
<li>
Возможно расширенное логирование.
</li>
<li>
Не применяется минификация и создание бандла для css, js файлов.
</li>
</ul>
<li>Production

Предназначен для решения работы сайта в продакшене.
Особенности работы:
<ul>
<li>
Ошибки и стэк-трейс не выводятся пользователю.
</li>
<li>
Ошибки в XML файлах не выводятся.
</li>
<li>
Статические файлы не создаются на лету, а уже соданы для использования.
</li>
<li>
Кэширование не может быть задизейблено в админке.
</li>
<li>
Логирование всегда запрещено.
</li>
<li>
Секция для дэвэлопмента в админке Stores > Congiguration > Advanced скрыта.
</li>
</ul>
</ol>