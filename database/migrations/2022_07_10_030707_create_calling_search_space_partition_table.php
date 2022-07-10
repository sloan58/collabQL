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
        Schema::create('calling_search_space_partition', function (Blueprint $table) {
            $table->unsignedBigInteger('calling_search_space_id');
            $table->foreign('calling_search_space_id')
                ->references('id')
                ->on('calling_search_spaces')
                ->onDelete('cascade');
            $table->unsignedBigInteger('partition_id');
            $table->foreign('partition_id')
                ->references('id')
                ->on('partitions')
                ->onDelete('cascade');
            $table->integer('index');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('calling_search_space_partition');
    }
};
