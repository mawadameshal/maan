<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCitizensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('citizens', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name');
             $table->string('email')->nullable();
             $table->string('father_name');
             $table->string('last_name');
            $table->string('grandfather_name');
            $table->integer('id_number');
            $table->string('governorate');
            $table->string('city');
             $table->string('street');
            $table->string('add_byself')->default('1');
            $table->string('mobile')->nullable();
            
            
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
        Schema::dropIfExists('citizens');
    }
}
