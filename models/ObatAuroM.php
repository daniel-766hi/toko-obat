<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "obat_auro_m".
 *
 * @property int $id_obat
 * @property string $nama_obat
 * @property string|null $jenis_obat
 * @property string|null $deskripsi_obat
 * @property int|null $stock_obat
 * @property string $satuan_obat
 * @property int $harga_obat
 *
 * @property PembelianObat[] $pembObatAuroTs
 */
class ObatAuroM extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'obat_auro_m';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nama_obat', 'satuan_obat', 'harga_obat'], 'required'],
            [['nama_obat', 'jenis_obat', 'deskripsi_obat', 'satuan_obat'], 'string'],
            [['stock_obat', 'harga_obat'], 'default', 'value' => null],
            [['stock_obat', 'harga_obat'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_obat' => 'Id Obat',
            'nama_obat' => 'Nama Obat',
            'jenis_obat' => 'Jenis Obat',
            'deskripsi_obat' => 'Deskripsi Obat',
            'stock_obat' => 'Stock Obat',
            'satuan_obat' => 'Satuan Obat',
            'harga_obat' => 'Harga Obat',
        ];
    }

    /**
     * Gets query for [[PembObatAuroTs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPembObatAuroTs()
    {
        return $this->hasMany(PembObatAuroT::class, ['id_obat' => 'id_obat']);
    }
}
