<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCrmPoinsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crm_poins', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_productType');
            $table->integer('distributor_jual');
            $table->integer('distributor_reseller_jual');
            $table->integer('reseller_jual');
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
        Schema::dropIfExists('crm_poins');
    }
}
