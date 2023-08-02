<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionHistorySellsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction_history_sells', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_code');
            $table->foreignId('id_group');
            $table->foreignId('id_distributor');
            $table->foreignId('id_owner');
            $table->foreignId('id_input');
            $table->string('nama_input');
            $table->foreignId('id_approve');
            $table->string('nama_approve');
            $table->integer('jumlah_barang');
            $table->date('tanggal_pesan');
            $table->time('jam_pesan');
            $table->integer('diskon');
            $table->string('keterangan_diskon');
            $table->integer('total');
            $table->integer('status_pesanan');
            $table->integer('total_crm_poin_distributor');
            $table->integer('total_crm_poin_reseller');
            $table->string('metode_pembayaran');
            $table->foreignId('id_reset_poin_crm_distributor');
            $table->foreignId('id_reset_poin_crm');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaction_history_sells');
    }
}
