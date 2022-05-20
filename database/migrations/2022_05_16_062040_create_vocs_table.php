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
        Schema::create('vocs', function (Blueprint $table) {
            $table->id();
            $table->string('word');
            $table->integer('memorize');
            $table->string('wordinfo1')->nullable();
            $table->string('wordinfo2')->nullable();
            $table->string('wordinfo3')->nullable();
            $table->string('wordinfo4')->nullable();
            $table->string('meaning1');
            $table->string('meaning2')->nullable();
            $table->string('meaning3')->nullable();
            $table->string('meaning4')->nullable();
            $table->integer('part_of_speech');
            $table->string('parentheses')->nullable();
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
        Schema::dropIfExists('vocs');
    }
};
