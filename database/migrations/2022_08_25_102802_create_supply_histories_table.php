<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupplyHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supply_histories', function (Blueprint $table) {
            $table->id();
            $table->string('kode_pasok');
            $table->string('nama_supplier');
            $table->string('surat_jalan');
            $table->foreignId('id_input');
            $table->string('nama_input');
            $table->integer('total');
            $table->string('metode_pembayaran');
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
        Schema::dropIfExists('supply_histories');
    }
}
