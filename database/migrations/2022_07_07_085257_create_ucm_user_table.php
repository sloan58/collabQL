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
        Schema::create('ucm_user', function (Blueprint $table) {
            $table->unsignedBigInteger('ucm_id')->index();
            $table->foreign('ucm_id')
                ->references('id')
                ->on('ucms')
                ->onDelete('cascade');
            $table->unsignedBigInteger('user_id')->index();
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            $table->string('pkid');
            $table->string('userId');
            $table->string('serviceProfile')->nullable();
            $table->boolean('homeCluster')->default(false);
//            $table->primary(['ucm_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ucm_user');
    }
};
