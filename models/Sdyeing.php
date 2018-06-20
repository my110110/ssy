<?php

namespace app\models;

use Yii;
use app\components\behaviors\UploadBehavior;

/**
 * This is the model class for table "sdyeing".
 *
 * @property integer $id
 * @property string $retrieve
 * @property string $section_name
 * @property string $section_type
 * @property string $section_thickness
 * @property string $section_preprocessing
 * @property string $testflow
 * @property string $img
 * @property string $place
 * @property integer $add_user
 * @property string $add_time
 * @property integer $change_user
 * @property string $change_time
 * @property integer $isdel
 * @property string $del_time
 * @property integer $del_user
 * @property integer $nid
 * @property integer $ntype
 * @property string $kit
 * @property string $rgid
 * @property string $attention
 * @package app\models
 * @method uploadImgFile()
 */
class Sdyeing extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sdyeing';
    }
    static $section_type=[
        '冰冻切片'=>'冰冻切片',
        '石蜡切片'=>'石蜡切片',
        '细胞爬片'=>'细胞爬片',
        '细胞甩/辅片'=>'细胞甩/辅片',
    ];
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['section_name', 'section_type'], 'required'],
            [['testflow', 'attention'], 'string'],
            [['add_user', 'change_user', 'isdel', 'del_user', 'nid', 'ntype'], 'integer'],
            [['add_time', 'change_time', 'del_time'], 'safe'],
            [['retrieve', 'section_name', 'section_type', 'section_thickness', 'img', 'place', 'kit', 'rgid'], 'string', 'max' => 100],
            [['section_preprocessing'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'retrieve' => 'Retrieve',
            'section_name' => '切片名称',
            'section_type' => '切片类型',
            'section_thickness' => '切片厚度',
            'section_preprocessing' => '切片预处理',
            'testflow' => '实验流程',
            'img' => 'Img',
            'place' => '存放位置',
            'add_user' => 'Add User',
            'add_time' => 'Add Time',
            'change_user' => 'Change User',
            'change_time' => 'Change Time',
            'isdel' => 'Isdel',
            'del_time' => 'Del Time',
            'del_user' => 'Del User',
            'nid' => 'Nid',
            'ntype' => 'Ntype',
            'kit' => 'Kit',
            'rgid' => 'Rgid',
            'attention' => '注意事项',
            'imageFile'=>'切片数字图像文件'
        ];
    }


    public function beforeSave($insert)
    {

        $res = parent::beforeSave($insert);
        if($res==false){
            return $res;
        }
        if (!$this->validate()) {
            Yii::info('Model not updated due to validation error.', __METHOD__);
            return false;
        }
        $file = $this->uploadImgFile();
        if($file){
            $this->img = $file;
        }
        return true;
    }

    public function behaviors()
    {
        return [
            [
                'class'=>UploadBehavior::className(),
                'saveDir'=>'products-img/'
            ]
        ];
    }

}
