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
        Schema::create('devices', function (Blueprint $table) {
            $table->id();
            $table->string('pkid');
            $table->string('name');
            $table->string('description')->nullable();
            $table->string('model')->nullable();
            $table->string('class')->nullable();
            $table->string('ipAddress')->nullable();
            $table->enum('status', [
                'Registered',
                'PartiallyRegistered',
                'UnRegistered',
                'Rejected',
                'Unknown'
            ])->default('Unknown');
            $table->string('registeredWith')->nullable();
            $table->string('protocol')->nullable();
            $table->string('activeLoad')->nullable();
            $table->string('inactiveLoad')->nullable();
            $table->unsignedBigInteger('device_pool_id')
                ->index()
                ->nullable();
            $table->foreign('device_pool_id')
                ->references('id')
                ->on('device_pools')
                ->onDelete('SET NULL');
            $table->unsignedBigInteger('calling_search_space_id')
                ->index()
                ->nullable();
            $table->foreign('calling_search_space_id')
                ->references('id')
                ->on('calling_search_spaces')
                ->onDelete('SET NULL');
            $table->unsignedBigInteger('ucm_id')->index();
            $table->foreign('ucm_id')
                ->references('id')
                ->on('ucms')
                ->onDelete('cascade');
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
        Schema::dropIfExists('devices');
    }
};
