<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction_histories', function (Blueprint $table) {
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
            $table->integer('total');
            $table->integer('status_pesanan');
            $table->integer('total_crm_poin_distributor');
            $table->string('metode_pembayaran');
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
        Schema::dropIfExists('transaction_histories');
    }
}
