<?php

namespace baxriev\vote\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use baxriev\vote\models\VoteResult;

/**
 * VoteResultSearch represents the model behind the search form of `common\models\VoteResult`.
 */
class VoteResultSearch extends VoteResult
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'questions_id', 'answer_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
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
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = VoteResult::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'questions_id' => $this->questions_id,
            'answer_id' => $this->answer_id,
        ]);

        return $dataProvider;
    }
}
