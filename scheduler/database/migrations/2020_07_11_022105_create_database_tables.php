<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDatabaseTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedule', function (Blueprint $table) {
            $table->id();
            $table->string('name', 500);
            $table->string('slug', 500);
            $table->smallInteger('active')->default(0);
            $table->date('start_date');
            $table->time('start_time');
            $table->date('end_date');
            $table->time('end_time');
            $table->string('playlist', 500);
            $table->smallInteger('randomize')->default(0);
            $table->smallInteger('play_single')->default(0);
            $table->mediumInteger('repeat_interval')->default(0);
            $table->string('custom_interval', 30);
            $table->string('stop_type', 50)->default(0);
            $table->integer('priority')->default(0);
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
        Schema::dropIfExists('schedule');
    }
}
