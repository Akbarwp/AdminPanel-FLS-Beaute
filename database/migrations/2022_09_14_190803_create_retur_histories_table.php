<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReturHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('retur_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_transaction');
            $table->foreignId('id_group');
            $table->foreignId('id_supplier');
            $table->foreignId('id_owner');
            $table->foreignId('id_input');
            $table->string('nama_input');
            $table->foreignId('id_approve');
            $table->string('nama_approve');
            $table->string('surat_keluar');
            $table->string('keterangan');
            $table->integer('jumlah_barang');
            $table->integer('total');
            $table->integer('status_retur');
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
        Schema::dropIfExists('retur_histories');
    }
}
