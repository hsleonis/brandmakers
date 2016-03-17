Chained DropDownList Widget for Yii2
========================

Implement DropDownList chained width other DropDownList.

Installation
------------
The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require "himiklab/yii2-chained-dropdown-list-widget" "*"
```
or add

```json
"himiklab/yii2-chained-dropdown-list-widget" : "*"
```

to the require section of your application's `composer.json` file.

Usage
-----
Using as field in ActiveForm:

```php
use himiklab\chained\ChainedDropDownList;

<?= $form->field($model, 'news')->widget(
    ChainedDropDownList::className(),
    [
        'items' => [],
        'remote' => [
            'id' => 'language-drop-down',
            'url' => Url::to('newsList')
        ]
    ]
); ?>
```

Using inline:

```php
use himiklab\chained\ChainedDropDownList;

<?= ChainedDropDownList::widget([
    'items' => [],
    'remote' => [
        'id' => 'language-drop-down',
        'url' => Url::to('newsList')
    ]
]); ?>
```
