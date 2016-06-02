<?php
/**
 * Created by PhpStorm.
 * User: guoxiaosong
 * Date: 2016/1/12
 * Time: 下午2:49
 */
namespace mztest\singleFileUpload;

use mztest\singleFileUpload\assets\SingleFileUploadAsset;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\InputWidget;

class SingleFileUpload extends InputWidget
{
    public $uploadAction;

    public function init()
    {
        parent::init();

        if (!isset($this->options['class'])) {
            $this->options['class'] = 'form-control';
        }

        if (!isset($this->options['placeholder'])) {
            $this->options['placeholder'] = '点击右侧按钮上传图片，或者直接写入图片地址';
        }

        if (!is_array($this->uploadAction)) {
            $this->uploadAction = [$this->uploadAction];
        }
        $this->uploadAction = Url::toRoute(ArrayHelper::merge(
            ['inputName' => $this->getFileInputName()],
            $this->uploadAction)
        );

    }
    public function run()
    {

        $view = $this->getView();
        SingleFileUploadAsset::register($view);
        $view->registerJs("$('#".$this->getFileInputId()."').fileupload({
            url: '". $this->uploadAction ."',
            dataType: 'json',
            acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
            maxNumberOfFiles: 1,
            maxFileSize: 2000000, // 2 MB,
            start: function(e, data) {
                $(this).prev('span').button('loading');
            },
            done: function (e, data) {
                var result = data.result;
                var file = data.result.files[0];
                $(this).parents('.input-group').find('input[type=text]').val(file.relativeUrl);
                $(this).prev('span').button('reset');
            }
        })");

        echo $this->renderInput();
    }

    protected function renderInput()
    {
        $fileButton = '<span class="input-group-addon"><span class="fileinput-button">'
            . '<i class="glyphicon glyphicon-plus"></i>'
            . '<span data-loading-text="上传中...">上传图片 ...</span>'
            . Html::fileInput($this->getFileInputName(), '', [
                'id' => $this->getFileInputId(),
                'class' => 'single-file-upload'
            ])
            . '</span></span>';

        if ($this->hasModel()) {
            $input = Html::activeTextInput($this->model, $this->attribute, $this->options);
        } else {
            $input = Html::textInput($this->name, '', $this->options);
        }

        return '<div class="input-group">'. $input. $fileButton . '</div>';
    }

    protected function getFileInputName()
    {
        if ($this->hasModel()) {
            $name = preg_replace('[\[|\]]', '-', Html::getInputName($this->model, $this->attribute));
        } else {
            $name = $this->name;
        }

        return '_file_'. $name;
    }

    protected function getFileInputId()
    {
        return '_file_'. $this->getId();
    }
}