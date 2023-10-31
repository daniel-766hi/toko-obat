<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\PembelianObat;

/**
 * PencBeli represents the model behind the search form of `app\models\PembelianObat`.
 */
class PencBeli extends PembelianObat
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_pembelian', 'id_obat', 'banyak_dibeli'], 'integer'],
            [['harga_jual', 'harga_beli'], 'number'],
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
        $query = PembelianObat::find();

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
            'id_pembelian' => $this->id_pembelian,
            'id_obat' => $this->id_obat,
            'harga_jual' => $this->harga_jual,
            'harga_beli' => $this->harga_beli,
            'banyak_dibeli' => $this->banyak_dibeli,
        ]);

        return $dataProvider;
    }
}
