<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "sdyeing".
 *
 * @property integer $id
 * @property string $retrieve
 * @property string $section_name
 * @property string $section_type
 * @property string $section_thickness
 * @property string $section_preprocessing
 * @property string $testflow
 * @property string $img
 * @property string $place
 * @property integer $add_user
 * @property string $add_time
 * @property integer $change_user
 * @property string $change_time
 * @property integer $isdel
 * @property string $del_time
 * @property integer $del_user
 * @property integer $nid
 * @property integer $ntype
 * @property string $kit
 * @property string $rgid
 * @property string $attention
 */
class Sdyeing extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sdyeing';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['section_name', 'section_type'], 'required'],
            [['testflow', 'attention'], 'string'],
            [['add_user', 'change_user', 'isdel', 'del_user', 'nid', 'ntype'], 'integer'],
            [['add_time', 'change_time', 'del_time'], 'safe'],
            [['retrieve', 'section_name', 'section_type', 'section_thickness', 'img', 'place', 'kit', 'rgid'], 'string', 'max' => 100],
            [['section_preprocessing'], 'string', 'max' => 255],
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
            'section_name' => 'Section Name',
            'section_type' => 'Section Type',
            'section_thickness' => 'Section Thickness',
            'section_preprocessing' => 'Section Preprocessing',
            'testflow' => 'Testflow',
            'img' => 'Img',
            'place' => 'Place',
            'add_user' => 'Add User',
            'add_time' => 'Add Time',
            'change_user' => 'Change User',
            'change_time' => 'Change Time',
            'isdel' => 'Isdel',
            'del_time' => 'Del Time',
            'del_user' => 'Del User',
            'nid' => 'Nid',
            'ntype' => 'Ntype',
            'kit' => 'Kit',
            'rgid' => 'Rgid',
            'attention' => 'Attention',
        ];
    }
}
