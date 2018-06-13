<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "particular".
 *
 * @property integer $id
 * @property string $name
 * @property string $retrieve
 * @property integer $change_user
 * @property string $add_time
 * @property string $del_time
 * @property string $change_time
 */
class Particular extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'particular';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [ ['name'], 'required'],
            [[ 'change_user'], 'integer'],
            [['add_time', 'del_time', 'change_time'], 'safe'],
            [['name', 'retrieve'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '指标名称',
            'retrieve' => '检索号',
            'change_user' => 'Change User',
            'add_time' => 'Add Time',
            'del_time' => 'Del Time',
            'change_time' => 'Change Time',
        ];
    }
}
