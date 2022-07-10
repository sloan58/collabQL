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
        Schema::create('numplans', function (Blueprint $table) {
            $table->id();
            $table->string('pkid');
            $table->string('pattern');
            $table->string('description')->nullable();
            $table->string('patternUsage');
            $table->unsignedBigInteger('ucm_id')->index();
            $table->foreign('ucm_id')
                ->references('id')
                ->on('ucms')
                ->onDelete('cascade');
            $table->unsignedBigInteger('partition_id')->index()->nullable();
            $table->foreign('partition_id')
                ->references('id')
                ->on('partitions')
                ->onDelete('cascade');
            $table->unique(['ucm_id', 'pkid']);
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
        Schema::dropIfExists('numplans');
    }
};
