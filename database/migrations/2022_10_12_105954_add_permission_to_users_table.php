<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPermissionToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('lihat_barang');
            $table->boolean('tambah_barang');
            $table->boolean('edit_barang');
            $table->boolean('hapus_barang');
            $table->boolean('pasok_barang');

            $table->boolean('lihat_tracking_sales');

            $table->boolean('lihat_crm');
            $table->boolean('input_poin_crm');
            $table->boolean('input_reward_crm');
            $table->boolean('acc_reward');

            $table->boolean('lihat_pos');
            $table->boolean('input_pos');
            $table->boolean('acc_transaksi');

            $table->boolean('input_retur');
            $table->boolean('acc_retur');

            $table->boolean('lihat_laporan_penjualan');
            $table->boolean('lihat_laporan_pembelian');
            $table->boolean('lihat_laporan_pegawai');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
}
