<?php
/**
 * Created by PhpStorm.
 * User: guoxiaosong
 * Date: 2016/1/11
 * Time: 下午2:57
 */

namespace mztest\singleFileUpload;

use yii\web\AssetBundle;

class SingleFileUploadAsset extends AssetBundle
{
    public $sourcePath = '@vendor/blueimp/jquery-file-upload';
    public $css = [
        'css/jquery.fileupload.css',
    ];
    public $js = [
        'js/vendor/jquery.ui.widget.js',
        'js/jquery.iframe-transport.js',
        'js/jquery.fileupload.js',
        'js/jquery.fileupload-process.js',
        'js/jquery.fileupload-validate.js',
    ];

    public $publishOptions = [
        'only' => [
            '*.js',
            'css/*',
            'img/*'
        ]
    ];

    public $depends = [
        'backend\assets\AppAsset',
    ];
}