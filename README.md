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
1. Define your web base url aliase '@frontendWeb'

```php
Yii::setAlias('@frontendWeb', 'http://your.domain.com');
```

2. Set upload action at your controller

```php
public function actions()
    {
        return [
            'upload' => [
                'class' => 'mztest\singleFileUpload\actions\SingleFileUploadAction',
                'uploadFolder' => 'your relative upload folder name.',
            ],
        ];
    }
```

3. simply use it in your code by  :

```php
<?= \mztest\singleFileUpload\SingelFileUpload::widget(); ?>
```

or

```php
<?= $form->field($model, 'floor_image')->widget(SingleFileUpload::className(), [
    'uploadAction' => ['upload']
]) ?>
```