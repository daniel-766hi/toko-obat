<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "penju_obat_auro_t".
 *
 * @property int $id_penjualan
 * @property string $nama_pembeli
 * @property int $banyak_pembelian
 * @property int|null $harga_pembelian
 * @property string $nama_obat
 * @property int|null $harga_jual
 */
class PenjualanObat extends \yii\db\ActiveRecord
{
    public $id_obat;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'penju_obat_auro_t';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nama_pembeli', 'banyak_pembelian', 'nama_obat', 'tanggal_transaksi'], 'required'],
            [['nama_pembeli', 'nama_obat'], 'string'],
            [['banyak_pembelian', 'harga_pembelian'], 'default', 'value' => null],
            [['banyak_pembelian', 'harga_pembelian'], 'integer'],
            [['nama_obat','nama_obat'],'string']
        ];
    }
    public function getObatAuroM()
    {
        return $this->hasOne(ObatAuroM::class, ['id_obat' => 'id_obat']);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_penjualan' => 'Id Penjualan',
            'nama_pembeli' => 'Nama Pembeli',
            'banyak_pembelian' => 'Banyak Pembelian',
            'harga_pembelian' => 'Harga Pembelian',
            'nama_obat' => 'Nama Obat',
            'tanggal_transaksi' => 'Tanggal Transaksi',
        ];
    }
}
