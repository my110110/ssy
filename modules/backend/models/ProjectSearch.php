<?php

namespace app\modules\backend\models;

use app\models\Project;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * ContentSearch represents the model behind the search form about `app\models\Content`.
 */
class ProjectSearch extends Project
{

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pro_name', 'pro_retrieve','pro_pid'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
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
        $query = Project::find();

        // add conditions that should always apply here
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=>['defaultOrder'=>['pro_id'=>SORT_DESC]],
            'pagination' => ['pageSize'=>$pageSize]
        ]);

        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere(['pro_retrieve' => $this->pro_retrieve,]);
        $query->andFilterWhere(['like', 'pro_name', $this->pro_name]);
        return $dataProvider;
    }



}
