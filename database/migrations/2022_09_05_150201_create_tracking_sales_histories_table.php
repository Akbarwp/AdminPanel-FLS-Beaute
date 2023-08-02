<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrackingSalesHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tracking_sales_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_group');
            $table->foreignId('id_reseller');
            $table->string('nama_toko');
            $table->string('longitude');
            $table->string('latitude');
            $table->string('address');
            $table->string('nilai');
            $table->string('saran');
            $table->integer('total')->default(false);
            $table->integer('total_crm_poin_distributor');
            $table->integer('total_crm_poin_sales');
            $table->integer('total_bonus_penjualan_sales');
            $table->foreignId('id_reset_poin_crm_distributor');
            $table->foreignId('id_reset_poin_crm');
            $table->foreignId('id_akumulasi_bonus_penjualan_sales');
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
        Schema::dropIfExists('tracking_sales_histories');
    }
}
