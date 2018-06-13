<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "testmethod".
 *
 * @property integer $id
 * @property string $name
 * @property string $retrieve
 * @property string $positive
 * @property string $negative
 * @property string $judge
 * @property string $matters
 * @property string $add_time
 * @property string $change_time
 * @property integer $chang_user
 * @property integer $isdel
 * @property string $del_time
 */
class Testmethod extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'testmethod';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[ 'name'], 'required'],
            [[ 'chang_user', 'isdel'], 'integer'],
            [['add_time', 'change_time', 'del_time'], 'safe'],
            [['name', 'retrieve'], 'string', 'max' => 100],
            [['positive', 'negative', 'judge', 'matters'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'pid' => 'ID',
            'name' => '检测名称方法',
            'retrieve' => '检索号',
            'positive' => '阳性对照',
            'negative' => '阴性对照',
            'judge' => '结果判断',
            'matters' => '注意事项',
            'add_time' => 'Add Time',
            'change_time' => 'Change Time',
            'chang_user' => 'Chang User',
            'isdel' => 'Isdel',
            'del_time' => 'Del Time',
        ];
    }
}
