<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesStokHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_stok_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_group');
            $table->foreignId('id_distributor');
            $table->foreignId('id_owner');
            $table->foreignId('id_input');
            $table->string('nama_input');
            $table->foreignId('id_approve');
            $table->string('nama_approve');
            $table->integer('jumlah_barang');
            $table->integer('total');
            $table->boolean('status');
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
        Schema::dropIfExists('sales_stok_histories');
    }
}
