<?php

namespace app\modules\backend\models;

use Yii;

/**
 * This is the model class for table "operatelog".
 *
 * @property integer $id
 * @property integer $operate
 * @property integer $object
 * @property integer $user
 * @property string $operate_kind
 * @property string $objectname
 * @property string $operate_time
 */
class operatelog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'operatelog';
    }

    static $operate_kind=[
        '1'=>'实验项目',
        '2'=>'实验分组',
        '3'=>'实验负责人',
        '4'=>'样品'
    ];
   static $view=[
       '1'=>'project/view',
       '2'=>'group/view',
       '3'=>'principal/view',
       '4'=>'sample/view'
   ];
    static $operate=[
        '1'=>'添加',
        '2'=>'导入',
        '3'=>'修改',
        '4'=>'删除',
    ];
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['operate', 'object', 'user', 'objectname','operate_kind'], 'required'],
            [['operate', 'object', 'user'], 'integer'],
            [['operate_time'], 'safe'],
            [['objectname'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'operate' => '操作',
            'object' => '对象',
            'user' => '操作人',
            'objectname' => '对象名称',
            'operate_time' => 'Operate Time',
            'operate_kind'=>'操作类型'
        ];
    }


}
