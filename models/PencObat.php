<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ObatAuroM;

/**
 * PencObat represents the model behind the search form of `app\models\ObatAuroM`.
 */
class PencObat extends ObatAuroM
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_obat', 'stock_obat', 'harga_obat'], 'integer'],
            [['nama_obat', 'jenis_obat', 'deskripsi_obat', 'satuan_obat'], 'safe'],
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
        $query = ObatAuroM::find();

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
            'id_obat' => $this->id_obat,
            'stock_obat' => $this->stock_obat,
            'harga_obat' => $this->harga_obat,
        ]);

        $query->andFilterWhere(['ilike', 'nama_obat', $this->nama_obat])
            ->andFilterWhere(['ilike', 'jenis_obat', $this->jenis_obat])
            ->andFilterWhere(['ilike', 'deskripsi_obat', $this->deskripsi_obat])
            ->andFilterWhere(['ilike', 'satuan_obat', $this->satuan_obat]);

        return $dataProvider;
    }
}
