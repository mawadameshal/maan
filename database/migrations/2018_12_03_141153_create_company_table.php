<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompanyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('welcom_word');
            $table->string('welcom_clouse');
            $table->string('add_compline_clouse');
            $table->string('add_propusel_clouse');
            $table->string('add_thanks_clouse');
            $table->string('follw_compline_clouse');
            $table->longText('how_we');
            $table->string('mopile');
            $table->string('phone');
            $table->string('free_number');
            $table->string('mail');
            $table->string('address');
            $table->string('fax');
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
        Schema::dropIfExists('company');
    }
}
