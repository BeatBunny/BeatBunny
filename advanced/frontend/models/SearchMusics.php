<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Musics;

/**
 * SearchMusics represents the model behind the search form of `\frontend\models\Musics`.
 */
class SearchMusics extends Musics
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'genres_id', 'albums_id', 'iva_id'], 'integer'],
            [['title', 'launchdate', 'lyrics', 'musiccover'], 'safe'],
            [['rating', 'pvp'], 'number'],
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
        $query = Musics::find();

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
            'launchdate' => $this->launchdate,
            'rating' => $this->rating,
            'pvp' => $this->pvp,
            'genres_id' => $this->genres_id,
            'albums_id' => $this->albums_id,
            'iva_id' => $this->iva_id,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'lyrics', $this->lyrics])
            ->andFilterWhere(['like', 'musiccover', $this->musiccover]);

        return $dataProvider;
    }
}
