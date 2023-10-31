<?php

use yii\db\Migration;

/**
 * Class m231011_021629_add_date_to_pembelian_obat
 */
class m231011_021629_add_date_to_pembelian_obat extends Migration
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
        echo "m231011_021629_add_date_to_pembelian_obat cannot be reverted.\n";

        return false;
    }

    public function up()
    {
        $this->addColumn('pemb_obat_auro_t', 'tanggal_transaksi', $this->date());
    }
    public function down()
    {
        $this->dropColumn('pemb_obat_auro_t', 'tanggal_transaksi');
    }

}
