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
 * @property integer $pid
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
            [['name'], 'required'],
            [['add_time', 'change_time', 'del_time'], 'safe'],
            [['chang_user', 'isdel', 'pid'], 'integer'],
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
            'id' => 'ID',
            'name' => 'Name',
            'retrieve' => 'Retrieve',
            'positive' => 'Positive',
            'negative' => 'Negative',
            'judge' => 'Judge',
            'matters' => 'Matters',
            'add_time' => 'Add Time',
            'change_time' => 'Change Time',
            'chang_user' => 'Chang User',
            'isdel' => 'Isdel',
            'del_time' => 'Del Time',
            'pid' => 'Pid',
        ];
    }
}
