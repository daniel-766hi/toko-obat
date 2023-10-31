<?php

use yii\db\Migration;

/**
 * Class m231011_022032_add_date_to_penjualan_obat
 */
class m231011_022032_add_date_to_penjualan_obat extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m231011_022032_add_date_to_penjualan_obat cannot be reverted.\n";

        return false;
    }
    public function up()
    {
        $this->addColumn('penju_obat_auro_t', 'tanggal_transaksi', $this->date());
    }
    public function down()
    {
        $this->dropColumn('penju_obat_auro_t', 'tanggal_transaksi');
    }

}
