<?php

namespace app\models;
use app\components\behaviors\UploadBehavior;
use Yii;


/**
 * This is the model class for table "{{%project}}".
 *
 * @property integer $pro_id
 * @property string $pro_name
 * @property string $pro_description
 * @property string $pro_keywords
 * @property integer $pro_kind_id
 * @property integer $pro_sample_count
 * @property integer $pro_principal_info
 * @property string $pro_add_time
 * @property string $pro_update_time
 * @property integer $pro_pid
 * @property string $pro_retrieve
 */
class Project extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%project}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pro_name', 'pro_kind_id', 'pro_principal_info', 'pro_add_time', 'pro_retrieve'], 'required','on' => ['create'],'message'=>"{attribute}不能为空"],
            [['pro_name', 'pro_kind_id', 'pro_principal_info', 'pro_retrieve'], 'required','on' => ['update']],
            [['pro_kind_id', 'pro_sample_count', 'pro_principal_info', 'pro_pid'], 'integer','on' => ['create','update'],'message'=>"{attribute}不能为空"],
            [['pro_add_time', 'pro_update_time'], 'safe','on' => ['create','update']],
            [['pro_name', 'pro_keywords'], 'string', 'max' => 100,'on' => ['create','update'],'message'=>"{attribute}不能超过100位"],
            [['pro_description'], 'string', 'max' => 255,'on' => ['create','update'],'message'=>"{attribute}不能超过200位"],
            [['pro_retrieve'], 'string', 'max' => 40,'on' => ['create','update'],'message'=>"{attribute}不能超过40位"],
        ];
    }

    /**
     * 定义场景
     */
  public function scenarios()
  {
      return [
         'update'=>['pro_name', 'pro_kind_id', 'pro_principal_info', 'pro_add_time', 'pro_retrieve'],
         'create'=>['pro_name', 'pro_kind_id', 'pro_principal_info', 'pro_add_time', 'pro_retrieve']
      ];
  }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'pro_id' => 'Pro ID',
            'pro_name' => 'Pro Name',
            'pro_description' => 'Pro Description',
            'pro_keywords' => 'Pro Keywords',
            'pro_kind_id' => 'Pro Kind ID',
            'pro_sample_count' => 'Pro Sample Count',
            'pro_principal_info' => 'Pro Principal Info',
            'pro_add_time' => 'Pro Add Time',
            'pro_update_time' => 'Pro Update Time',
            'pro_pid' => 'Pro Pid',
            'pro_retrieve' => 'Pro Retrieve',
        ];
    }
}
