<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrackingSalesDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tracking_sales_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_tracking_sales');
            $table->foreignId('id_produk');
            $table->string('nama_produk');
            $table->integer('jumlah');
            $table->integer('harga');
            $table->integer('total');
            $table->integer('crm_poin_distributor');
            $table->integer('crm_poin_sales');
            $table->integer('bonus_penjualan_sales');
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
        Schema::dropIfExists('tracking_sales_details');
    }
}
