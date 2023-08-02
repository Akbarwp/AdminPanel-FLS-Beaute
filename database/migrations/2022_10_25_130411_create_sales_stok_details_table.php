<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesStokDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_stok_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_sales_stok');
            $table->foreignId('id_product');
            $table->string('nama_produk');
            $table->integer('jumlah');
            $table->integer('harga_jual');
            $table->integer('total');
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
        Schema::dropIfExists('sales_stok_details');
    }
}
