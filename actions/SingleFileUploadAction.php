<?php
/**
 * Created by PhpStorm.
 * User: guoxiaosong
 * Date: 2016/1/11
 * Time: 下午2:54
 */
namespace mztest\singleFileUpload\actions;

use Yii;
use yii\base\Action;
use yii\helpers\FileHelper;
use yii\web\Response;
use yii\web\UploadedFile;

class SingleFileUploadAction extends Action
{
    public $uploadFolder = 'upload';

    public $uploadBasePath = '@frontend/web/public'; //file system path
    public $uploadBaseUrl = '@frontendWeb'; //web path

    public $imagePathFormat = '/{yyyy}/{mm}{dd}/{time}/{rand:14}';

    protected $relativeBaseUrl = '/public';
    private $fullName;

    public function init()
    {
        $this->uploadBasePath = $this->uploadBasePath .'/'. $this->uploadFolder;
        $this->relativeBaseUrl = $this->relativeBaseUrl .'/'. $this->uploadFolder;

        parent::init();
    }

    /**
     * Runs the action.
     */
    public function run()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $inputName = Yii::$app->request->get('inputName');
        $uploadedFile = UploadedFile::getInstancesByName($inputName)[0];
        if ($uploadedFile instanceof UploadedFile) {
            $uploadedFile->saveAs($this->getFullPath($uploadedFile));
            return ['files' => [
                [
                    'name' => $this->getFullName($uploadedFile),
                    'size' => $uploadedFile->size,
                    'url' => $this->getFullUrl($uploadedFile),
                    'relativeUrl' => $this->getRelativeUrl($uploadedFile),
                ]
            ]];
        }
        return [];
    }

    /**
     * @param UploadedFile $uploadedFile
     * @return bool|string
     */
    public function getFullUrl($uploadedFile)
    {
        return Yii::getAlias($this->uploadBaseUrl . $this->relativeBaseUrl . $this->getFullName($uploadedFile));
    }

    /**
     * @param UploadedFile $uploadedFile
     * @return string
     */
    public function getRelativeUrl($uploadedFile)
    {
        return $this->relativeBaseUrl . $this->getFullName($uploadedFile);
    }

    /**
     * @param UploadedFile $uploadedFile
     * @return bool|string
     * @throws \yii\base\Exception
     */
    public function getFullPath($uploadedFile)
    {
        $fullPath = Yii::getAlias($this->uploadBasePath . $this->getFullName($uploadedFile));

        FileHelper::createDirectory(dirname($fullPath));

        return $fullPath;
    }

    /**
     * @param UploadedFile $uploadedFile
     * @return string
     */
    private function getFullName($uploadedFile)
    {

        if ($this->fullName) {
            return $this->fullName;
        }
        //替换日期事件
        $t = time();
        $d = explode('-', date("Y-y-m-d-H-i-s"));
        $format = $this->imagePathFormat;
        $format = str_replace("{yyyy}", $d[0], $format);
        $format = str_replace("{yy}", $d[1], $format);
        $format = str_replace("{mm}", $d[2], $format);
        $format = str_replace("{dd}", $d[3], $format);
        $format = str_replace("{hh}", $d[4], $format);
        $format = str_replace("{ii}", $d[5], $format);
        $format = str_replace("{ss}", $d[6], $format);
        $format = str_replace("{time}", $t, $format);

        //替换随机字符串
        $randNum = rand(1, 10000000000) . rand(1, 10000000000);
        if (preg_match("/\{rand\:([\d]*)\}/i", $format, $matches)) {
            $format = preg_replace("/\{rand\:[\d]*\}/i", substr($randNum, 0, $matches[1]), $format);
        }

        $ext = $uploadedFile->getExtension();
        $this->fullName = $format . '.' .$ext;
        return $this->fullName;
    }

}