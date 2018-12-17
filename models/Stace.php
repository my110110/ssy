<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "stace".
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property string $retrieve
 * @property string $postion
 * @property string $materials
 * @property string $saves
 * @property string $embedding
 * @property string $fxed
 * @property string $place
 * @property integer $sid
 * @property integer $isdel
 * @property string $add_time
 * @property integer $add_user
 * @property string $change_time
 * @property integer $change_user
 * @property string $del_time
 * @property integer $del_useri
 * @property integer $pid
 */
class Stace extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'stace';
    }
    static $handle=[
        '取材'=>'取材',
        '保存'=>'保存',
        '固定'=>'固定',
        '包埋'=>'包埋'
    ];
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'retrieve', 'postion', 'materials', 'fixed','embedding', 'place','saves','pid'], 'required'],
            [['description'], 'string'],
            [['sid', 'isdel', 'add_user', 'change_user', 'del_user'], 'integer'],
            [['add_time', 'change_time', 'del_time'], 'safe'],
            [['name', 'retrieve', 'postion', 'place'], 'string', 'max' => 100],
            [['handle'], 'string', 'max' => 20],
        ];
    }

    /**
     * 定义场景
     */
    public function scenarios()
    {
        return [
            'search'=>[['name', 'retrieve'],'safe'],
            'default'=>['name','description','materials','saves', 'fixed','embedding','retrieve','postion','place','pid']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '名称',
            'description' => '描述',
            'retrieve' => 'Retrieve',
            'postion' => '组织/细胞部位',
            'materials' => '取材',
            'saves'=>'保存',
            'fixed'=>'固定',
            'embedding'=>'包埋',
            'place' => '存放位置',
            'sid' => 'Sid',
            'isdel' => 'Isdel',
            'add_time' => 'Add Time',
            'add_user' => 'Add User',
            'change_time' => 'Change Time',
            'change_user' => 'Change User',
            'del_time' => 'Del Time',
            'del_user' => 'Del User',
            'pid' => '项目id'
        ];
    }

    static function getParName($id)
    {
        $user= self::findOne($id);
        if($user){
            return $user->name;
        }else{
            return '';
        }


    }
}
