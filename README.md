
Утилиты UUID
==========
Базовые утилиты для проектов UUID.


Установка
------------

Лучше всего устанавливать через [Composer](http://getcomposer.org/download/).

Выполните

```
php composer.phar require --prefer-dist nex-otaku/yii2-uuid-tools "*"
```

или же добавьте

```
"nex-otaku/yii2-uuid-tools": "*"
```

в список "require" вашего файла `composer.json`.


Использование
-----

**UuidBehavior** - генерирует UUID для поля "id" при сохранении модели ActiveRecord.