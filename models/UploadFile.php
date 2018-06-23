<?php
namespace app\models;
use yii\base\Model;
use yii\web\UploadedFile;


class UploadFile extends Model
{


    /**
     * @var UploadedFile file attribute
     */
    public $file;
    public $pid;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['file'],'required'],
            [['file'], 'file'],
            [['pid'],'integer']
        ];
    }

}
