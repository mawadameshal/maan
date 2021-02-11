<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFormFollowsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('form_follows', function (Blueprint $table) {
            $table->increments('id');
             $table->integer('form_id');
			 $table->integer('citizen_id');
             $table->integer('solve')->nullable();
            $table->integer('evaluate')->nullable();
             $table->string('notes')->nullable();
             $table->date('datee');
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
        Schema::dropIfExists('form_follows');
    }
}
