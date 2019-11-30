<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\ProfileHasPlaylists;

/**
 * SearchProfileHasPlaylists represents the model behind the search form of `\common\models\ProfileHasPlaylists`.
 */
class SearchProfileHasPlaylists extends ProfileHasPlaylists
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['profile_id', 'playlists_id'], 'integer'],
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
        $query = ProfileHasPlaylists::find();

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
            'playlists_id' => $this->playlists_id,
        ]);

        return $dataProvider;
    }
}
