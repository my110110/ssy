<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "specal".
 *
 * @property integer $id
 * @property string $retrieve
 * @property string $axiom
 * @property string $process
 * @property string $add_time
 * @property string $change_time
 * @property string $del_time
 * @property integer $isdel
 */
class Specal extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'specal';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['retrieve', 'axiom'], 'required'],
            [['add_time', 'change_time', 'del_time'], 'safe'],
            [['isdel'], 'integer'],
            [['retrieve'], 'string', 'max' => 100],
            [['axiom', 'process'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'retrieve' => 'Retrieve',
            'axiom' => 'Axiom',
            'process' => 'Process',
            'add_time' => 'Add Time',
            'change_time' => 'Change Time',
            'del_time' => 'Del Time',
            'isdel' => 'Isdel',
        ];
    }
}
