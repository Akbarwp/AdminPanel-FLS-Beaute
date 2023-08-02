<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCrmClaimRewardHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crm_claim_reward_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_owner');
            $table->integer('sisa_poin');
            $table->foreignId('id_group');
            $table->foreignId('id_input');
            $table->string('nama_input');
            $table->foreignId('id_approve');
            $table->string('nama_approve');
            $table->foreignId('id_reward');
            $table->string('reward');
            $table->integer('poin');
            $table->string('detail_reward');
            $table->string('image');
            $table->boolean('status');
            $table->foreignId('id_reset_poin_crm');
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
        Schema::dropIfExists('crm_claim_reward_histories');
    }
}
