<?php

namespace app\models;

use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "kit".
 *
 * @property integer $id
 * @property string $name
 * @property string $number
 * @property string $company
 * @property string $http
 * @property string $method
 * @property string $savetion
 * @property integer $rid
 * @property integer $isdel
 * @property string $retrieve
 * @property string $file

 */
class Kit extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'kit';
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['rid', 'isdel'], 'integer'],
            [['name', 'number'], 'string', 'max' => 100],
            [['company', 'http', 'type', 'savetion', 'retrieve', 'file'], 'string', 'max' => 255],
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
            'number' => '货号',
            'company' => '公司名称',
            'http' => '官方网址',
            'type' => 'type',
            'savetion' => 'Savetion',
            'rid' => 'Rid',
            'isdel' => 'Isdel',
            'retrieve' => 'Retrieve',
            'file' => '试剂盒说明书',
            'retrieve'=>'编号'
        ];
    }

    static function getNames($arr){
        $str='';
        $data=self::find()->andFilterWhere(['id'=>json_decode($arr)?:0])->all();
        foreach ($data as $v){
            $str .=$v['name'].'  ';
        }
        return $str;
    }

}
