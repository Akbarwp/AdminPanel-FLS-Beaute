<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('user_position');
            $table->foreignId('id_group');
            $table->string('username')->unique();
            $table->string('image')->nullable();
            $table->string('password')->nullable();
            $table->string('firstname');
            $table->string('lastname');
            $table->string('no_hp');
            $table->string('ktp')->unique();
            $table->string('email')->unique();
            $table->unsignedBigInteger('province_id');
            $table->unsignedBigInteger('city_id');
            $table->string('address');
            $table->string('postcode');
            $table->rememberToken();
            $table->string('cluster')->nullable();
            $table->string('tokopedia')->nullable();
            $table->string('shopee')->nullable();
            $table->string('lazada')->nullable();
            $table->string('bukalapak')->nullable();
            $table->string('blibli')->nullable();
            $table->integer('id_input');
            $table->string('nama_input');
            $table->integer('crm_poin');
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
        Schema::dropIfExists('users');
    }
}
