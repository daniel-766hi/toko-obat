<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\PenjualanObat;

/**
 * PencJualan represents the model behind the search form of `app\models\PenjualanObat`.
 */
class PencJualan extends PenjualanObat
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_penjualan', 'banyak_pembelian', 'harga_pembelian'], 'integer'],
            [['nama_pembeli', 'nama_obat'], 'safe'],
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
        $query = PenjualanObat::find();

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
            'id_penjualan' => $this->id_penjualan,
            'banyak_pembelian' => $this->banyak_pembelian,
            'harga_pembelian' => $this->harga_pembelian,
        ]);

        $query->andFilterWhere(['ilike', 'nama_pembeli', $this->nama_pembeli])
            ->andFilterWhere(['ilike', 'nama_obat', $this->nama_obat]);

        return $dataProvider;
    }
}
