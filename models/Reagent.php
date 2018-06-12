<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "reagent".
 *
 * @property integer $id
 * @property string $name
 * @property string $retrieve
 * @property integer $isdel
 * @property integer $change_user
 * @property string $del_time
 * @property string $add_time
 * @property string $change_time
 */
class Reagent extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'reagent';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['isdel', 'change_user'], 'integer'],
            [['del_time', 'add_time', 'change_time'], 'safe'],
            [['name'], 'string', 'max' => 255],
            [['retrieve'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '试剂名称',
            'retrieve' => '检索号',
            'isdel' => 'Isdel',
            'change_user' => 'Change User',
            'del_time' => 'Del Time',
            'add_time' => 'Add Time',
            'change_time' => 'Change Time',
        ];
    }
}
