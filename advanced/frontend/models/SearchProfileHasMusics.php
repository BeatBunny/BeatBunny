<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\ProfileHasMusics;

/**
 * SearchProfileHasMusics represents the model behind the search form of `app\models\ProfileHasMusics`.
 */
class SearchProfileHasMusics extends ProfileHasMusics
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['profile_id', 'musics_id'], 'integer'],
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
        $query = ProfileHasMusics::find();

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
            'profile_id' => $this->profile_id,
            'musics_id' => $this->musics_id,
        ]);

        return $dataProvider;
    }
}
