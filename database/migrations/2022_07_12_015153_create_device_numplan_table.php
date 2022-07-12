<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('device_numplan', function (Blueprint $table) {
            $table->string('pkid');
            $table->string('numplanindex');
            $table->unsignedBigInteger('device_id')->index();
            $table->foreign('device_id')
                ->references('id')
                ->on('devices')
                ->onDelete('cascade');
            $table->unsignedBigInteger('numplan_id')->index();
            $table->foreign('numplan_id')
                ->references('id')
                ->on('numplans')
                ->onDelete('cascade');
            $table->unsignedBigInteger('ucm_id')->index();
            $table->foreign('ucm_id')
                ->references('id')
                ->on('ucms')
                ->onDelete('cascade');
            $table->unique(['device_id', 'numplan_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('device_numplan');
    }
};
