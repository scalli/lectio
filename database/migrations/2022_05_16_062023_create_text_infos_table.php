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
        Schema::create('text_infos', function (Blueprint $table) {
            $table->id();
            $table->string('text_title');
            $table->string('method');
            $table->string('chapter');
            $table->integer('grade');
            $table->string('extra_info');
            $table->string('author');
            $table->string('work');
            $table->string('passage');
            $table->integer('contributor');
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
        Schema::dropIfExists('text_infos');
    }
};
