<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Venda;

/**
 * SearchVenda represents the model behind the search form of `app\models\Venda`.
 */
class SearchVenda extends Venda
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'profile_id'], 'integer'],
            [['data'], 'safe'],
            [['valorTotal'], 'number'],
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
        $query = Venda::find();

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
            'data' => $this->data,
            'valorTotal' => $this->valorTotal,
            'profile_id' => $this->profile_id,
        ]);

        return $dataProvider;
    }
}
