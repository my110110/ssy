<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pna".
 *
 * @property integer $id
 * @property string $retrieve
 * @property string $name
 * @property string $OfficialSymbol
 * @property string $OfficialFullName
 * @property string $GeneID
 * @property string $function
 * @property string $NCBIgd
 * @property string $GeneGards
 * @property string $standard
 * @property string $cells
 * @property integer $isdel
 * @property string $add_time
 * @property string $del_time
 * @property string $change_time
 * @property integer $change_user
 */
class Pna extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pna';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['retrieve', 'name', 'GeneID'], 'required'],
            [['isdel', 'change_user'], 'integer'],
            [['add_time', 'del_time', 'change_time'], 'safe'],
            [['NCBIgd', 'GeneGards'], 'url'],
            [['retrieve', 'name', 'OfficialSymbol', 'OfficialFullName', 'GeneID', 'function', 'NCBIgd', 'GeneGards', 'standard', 'cells'], 'string', 'max' => 255],
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
            'name' => '名称',
            'OfficialSymbol' => '官方符号',
            'OfficialFullName' => '官方名称',
            'GeneID' => '基因ID',
            'function' => '基因/核酸功能',
            'NCBIgd' => 'NCBI基因数据库网址',
            'GeneGards' => 'GeneGards网址',
            'standard' => '阳性结果判定标准',
            'cells' => '阳性对照组织/细胞',
            'isdel' => 'Isdel',
            'add_time' => 'Add Time',
            'del_time' => 'Del Time',
            'change_time' => 'Change Time',
            'change_user' => 'Change User',
        ];
    }

    static function getParName($id)
    {
        $user= self::findOne($id);
        return $user->name;

    }
}
