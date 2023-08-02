<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionDetailSellsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction_detail_sells', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_transaction');
            $table->string('nama_produk');
            $table->string('jumlah');
            $table->integer('harga');
            $table->integer('total');
            $table->integer('id_product');
            $table->integer('crm_poin_distributor');
            $table->integer('crm_poin_reseller');
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
        Schema::dropIfExists('transaction_detail_sells');
    }
}
