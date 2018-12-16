<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "zipdel".
 *
 * @property integer $id
 * @property string $dirname
 * @property string $zipname
 * @property string $deltime
 */
class Zipdel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'zipdel';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['deltime'], 'safe'],
            [['dirname', 'zipname'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'dirname' => 'Dirname',
            'zipname' => 'Zipname',
            'deltime' => 'Deltime',
        ];
    }
}
