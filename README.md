Single file upload extension
============================
Single file upload extension

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist mztest/yii2-single-file-upload "*"
```

or add

```
"mztest/yii2-single-file-upload": "*"
```

to the require section of your `composer.json` file.


Usage
-----

Once the extension is installed, simply use it in your code by  :

```php
<?= \mztest\singleFileUpload\SingelFileUpload::widget(); ?>```