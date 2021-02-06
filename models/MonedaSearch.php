<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Moneda;

/**
 * MonedaSearch represents the model behind the search form of `app\models\Moneda`.
 */
class MonedaSearch extends Moneda
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idMoneda', 'idUsuario'], 'integer'],
            [['descripcion', 'simbolo', 'alias', 'fechaCreacion'], 'safe'],
            [['principal', 'activo'], 'boolean'],
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
        $query = Moneda::find();

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
            'idMoneda' => $this->idMoneda,
            'principal' => $this->principal,
            'fechaCreacion' => $this->fechaCreacion,
            'idUsuario' => $this->idUsuario,
            'activo' => $this->activo,
        ]);

        $query->andFilterWhere(['like', 'descripcion', $this->descripcion])
            ->andFilterWhere(['like', 'simbolo', $this->simbolo])
            ->andFilterWhere(['like', 'alias', $this->alias]);

        return $dataProvider;
    }
}
