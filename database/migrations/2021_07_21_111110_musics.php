<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Musics extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('musics',function(Blueprint $table){
           $table->id();
           $table->string('name');
           $table->string('band');
           $table->string('src');
           $table->string('img')->default('default.png');
           $table->integer('popularity')->default(0);
           $table->dateTime('release_date');
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
        Schema::dropIfExists('musics');
    }
}
