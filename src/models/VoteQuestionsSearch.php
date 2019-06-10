<?php

namespace baxriev\vote\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use baxriev\vote\models\VoteQuestions;

/**
 * VoteQuestionsSearch represents the model behind the search form of `common\models\VoteQuestions`.
 */
class VoteQuestionsSearch extends VoteQuestions
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'created_at', 'lang'], 'integer'],
            [['title', 'top', 'status', 'lang_hash'], 'safe'],
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
        $query = VoteQuestions::find();

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
            'created_at' => $this->created_at,
            'lang' => $this->lang,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'top', $this->top])
            ->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'lang_hash', $this->lang_hash]);

        return $dataProvider;
    }
}
