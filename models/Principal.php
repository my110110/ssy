<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "principal".
 *
 * @property integer $pro_id
 * @property string $name
 * @property string $department
 * @property string $email
 * @property string $telphone
 * @property integer $status
 */
class Principal extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'principal';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pro_id', 'name'], 'required'],
            [['pro_id', 'status'], 'integer'],
            [['email'],'email'],
            [['name', 'department', 'email', 'telphone'], 'string', 'max' => 40],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'pro_id' => 'Pro ID',
            'name' => '项目负责人姓名',
            'department' => '科室',
            'email' => 'Email',
            'telphone' => '联系电话',
            'status' => 'Status',
        ];
    }
}
