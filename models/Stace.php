<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "stace".
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property string $retrieve
 * @property string $postion
 * @property string $handle
 * @property string $place
 * @property integer $sid
 * @property integer $isdel
 * @property string $add_time
 * @property integer $add_user
 * @property string $change_time
 * @property integer $change_user
 * @property string $del_time
 * @property integer $del_user
 */
class Stace extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'stace';
    }
    static $handle=[
        '取材'=>'取材',
        '保存'=>'保存',
        '固定'=>'固定',
        '包埋'=>'包埋'
    ];
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'retrieve', 'postion', 'handle', 'place'], 'required'],
            [['description'], 'string'],
            [['sid', 'isdel', 'add_user', 'change_user', 'del_user'], 'integer'],
            [['add_time', 'change_time', 'del_time'], 'safe'],
            [['name', 'retrieve', 'postion', 'place'], 'string', 'max' => 100],
            [['handle'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '名称',
            'description' => '描述',
            'retrieve' => 'Retrieve',
            'postion' => '组织/细胞部位',
            'handle' => '处理方式',
            'place' => '存放位置',
            'sid' => 'Sid',
            'isdel' => 'Isdel',
            'add_time' => 'Add Time',
            'add_user' => 'Add User',
            'change_time' => 'Change Time',
            'change_user' => 'Change User',
            'del_time' => 'Del Time',
            'del_user' => 'Del User',
        ];
    }
}
