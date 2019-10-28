<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "company".
 *
 * @property integer $id
 * @property integer $number
 * @property string $company
 * @property string $http
 * @property string $method
 * @property string $savetion
 */
class Company extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'company';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['company', 'number','http', 'method', 'savetion'], 'string', 'max' => 255],
            [['http'], 'url'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'number' => '货号',
            'company' => '公司',
            'http' => '官网网址',
            'method' => '配置方法',
            'savetion' => '保存条件',
        ];
    }
}
