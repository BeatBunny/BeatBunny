<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Albums;

/**
 * AlbumsSearch represents the model behind the search form of `\common\models\Albums`.
 */
class AlbumsSearch extends Albums
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'genres_id'], 'integer'],
            [['title', 'launchdate', 'albumcover'], 'safe'],
            [['review'], 'number'],
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
        $query = Albums::find();

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
            'review' => $this->review,
            'genres_id' => $this->genres_id,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'albumcover', $this->albumcover]);

        return $dataProvider;
    }
}
