<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pemb_obat_auro_t".
 *
 * @property int $id_pembelian
 * @property int $id_obat
 * @property float $harga_jual
 * @property float $harga_beli
 * @property int $banyak_dibeli
 *
 * @property ObatAuroM $obat
 */
class PembelianObat extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pemb_obat_auro_t';
    }
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            // Mengambil data obat terkait
            $obat = ObatAuroM::findOne(['id_obat' => $this->id_obat]);

            if ($obat !== null) {
                // Menyesuaikan harga_jual berdasarkan satuan_obat
                if ($obat->satuan_obat === 'Botol') {
                    $this->harga_jual = $this->harga_beli + ($this->harga_beli * 0.3);
                } elseif ($obat->satuan_obat === 'Kaplet') {
                    $this->harga_jual = $this->harga_beli + ($this->harga_beli * 0.25);
                } elseif ($obat->satuan_obat === 'Tablet') {
                    $this->harga_jual = $this->harga_beli + ($this->harga_beli * 0.5);
                }
            }

            return true;
        }

        return false;
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        // Update harga_obat di ObatAuroM dengan harga_beli saat pembelian
        if ($insert) { // Hanya berlaku jika ini adalah pembelian baru
            $obat = ObatAuroM::findOne(['id_obat' => $this->id_obat]);
            if ($obat) {
                $obat->harga_obat = $this->harga_beli;
                $obat->save();
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['harga_beli', 'banyak_dibeli', 'tanggal_transaksi'], 'required'],            
            [['harga_jual', 'harga_beli'], 'number'],
            [['banyak_dibeli'], 'default', 'value' => null],
            [['banyak_dibeli'], 'integer'],
            [['id_obat'], 'exist', 'skipOnError' => true, 'targetClass' => ObatAuroM::class, 'targetAttribute' => ['id_obat' => 'id_obat']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_pembelian' => 'Id Pembelian',
            'id_obat' => 'Id Obat',
            'harga_jual' => 'Harga Jual',
            'harga_beli' => 'Harga Beli',
            'banyak_dibeli' => 'Banyak Dibeli',
            'tanggal_transaksi' => 'Tanggal Transaksi',
        ];
    }

    /**
     * Gets query for [[Obat]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getObat()
    {
        return $this->hasOne(ObatAuroM::class, ['id_obat' => 'id_obat']);
    }
}
