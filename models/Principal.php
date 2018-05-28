<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;


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

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     * @param int $pageSize
     * @return ActiveDataProvider
     */
    public function search($params, $pageSize=20)
    {
        $query = self::find();

        // add conditions that should always apply here
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=>['defaultOrder'=>['pro_id'=>SORT_DESC]],
            'pagination' => ['pageSize'=>$pageSize]
        ]);
        $query->andFilterWhere([
            'pro_id' => $params['pro_id'],
        ]);
        $this->load($params);


        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }



        return $dataProvider;
    }
}
