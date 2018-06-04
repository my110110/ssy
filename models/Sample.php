<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "sample".
 *
 * @property integer $id
 * @property string $name
 * @property string $img
 * @property string $retrieve
 * @property string $descript
 * @property string $add_user
 * @property string $add_time
 * @property string $change_time
 * @property integer $change_user
 * @property integer $isdel
 * @property integer $del_user
 * @property string $del_time
 */
class Sample extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sample';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name','add_user','add_time'], 'required'],
            [['descript'], 'string'],
            [['name', 'img', 'retrieve'], 'string', 'max' => 255],
            [['isdel'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '样本名称',
            'img' => 'Img',
            'retrieve' => 'Retrieve',
            'descript' => '样本描述',
        ];
    }
}
