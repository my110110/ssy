<?php

namespace app\models;

use Yii;
use app\components\behaviors\UploadBehavior;
/**
 * This is the model class for table "group".
 *
 * @property integer $id
 * @property string $group_retrieve
 * @property integer $pro_id
 * @property string $group_description
 * @property string $group_name
 * @property integer $group_sample_count
 * @property integer $group_sample_handle_type
 * @property string $group_experiment_type
 * @property string $group_add_time
 * @property integer $group_add_user
 * @property string $group_change_time
 * @property integer $group_change_user
 * @property string $group_del_time
 * @property integer $isdel
 * @property integer $group_del_user
 */
class Group extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'group';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pro_id','group_name'], 'required'],
            [['pro_id', 'group_sample_count', 'group_sample_handle_type', 'group_add_user', 'group_change_user', 'isdel', 'group_del_user'], 'integer'],
            [['group_experiment_type'], 'string'],
            [['group_add_time', 'group_change_time', 'group_del_time'], 'safe'],
            [['group_retrieve', 'group_description'], 'string', 'max' => 255],
            [['group_name'], 'string', 'max' => 50],
        ];
    }

    /**
     * 定义场景
     */
    public function scenarios()
    {
        return [
            'search'=>[['group_name', 'group_retrieve'],'safe'],
            'default'=>['group_name','group_retrieve','group_experiment_type','group_description','group_sample_count']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'group_retrieve' => '实验分组检索号',
            'pro_id' => 'Pro ID',
            'group_description' => '实验分组描述',
            'group_name' => '实验分组名称',
            'group_sample_count' => '样本数量',
            'group_sample_handle_type' => 'Group Sample Handle Type',
            'group_experiment_type' => '样本处理方式',
            'group_add_time' => 'Group Add Time',
            'group_add_user' => 'Group Add User',
            'group_change_time' => 'Group Change Time',
            'group_change_user' => 'Group Change User',
            'group_del_time' => 'Group Del Time',
            'isdel' => 'Isdel',
            'url'=>'URL',
            'group_del_user' => 'Group Del User',
            'imageFile'=>'样本图片'
        ];
    }
    static function getParName($id)
    {
        $user= self::findOne($id);
        return $user->group_name;

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
            $this->url = $file;
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
