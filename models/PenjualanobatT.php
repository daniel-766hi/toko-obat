<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "penjualanobat_t".
 *
 * @property int $penjualanobat_id
 * @property string|null $nama_pembeli
 * @property int|null $qty
 * @property int|null $harga
 * @property int|null $obat_id
 */
class PenjualanobatT extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'penjualanobat_t';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nama_pembeli'], 'string'],
            [['qty', 'harga', 'obat_id'], 'default', 'value' => null],
            [['qty', 'harga', 'obat_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'penjualanobat_id' => 'Penjualanobat ID',
            'nama_pembeli' => 'Nama Pembeli',
            'qty' => 'Banyak Pembelian',
            'harga' => 'Harga Obat',
            'obat_id' => 'Nama Obat',
        ];
    }
}
