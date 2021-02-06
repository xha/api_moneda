<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Tasa;

/**
 * TasaSearch represents the model behind the search form of `app\models\Tasa`.
 */
class TasaSearch extends Tasa
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idTasa', 'idMoneda', 'idUsuario'], 'integer'],
            [['fechaOperacion'], 'safe'],
            [['tasaActual'], 'number'],
            [['activo'], 'boolean'],
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
        $query = Tasa::find();

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
            'idTasa' => $this->idTasa,
            'idMoneda' => $this->idMoneda,
            'tasaActual' => $this->tasaActual,
            'fechaOperacion' => $this->fechaOperacion,
            'idUsuario' => $this->idUsuario,
            'activo' => $this->activo,
        ]);

        return $dataProvider;
    }
}
