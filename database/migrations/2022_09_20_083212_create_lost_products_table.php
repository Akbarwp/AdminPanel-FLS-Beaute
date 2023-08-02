<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLostProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lost_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_owner');
            $table->foreignId('id_input');
            $table->string('nama_input');
            $table->foreignId('id_product');
            $table->string('nama_produk');
            $table->integer('stok_real');
            $table->integer('stok_hilang');
            $table->integer('stok_sisa');
            $table->integer('harga_modal');
            $table->integer('total_kerugian');
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
        Schema::dropIfExists('lost_products');
    }
}
