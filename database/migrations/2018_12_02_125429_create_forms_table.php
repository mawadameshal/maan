<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('forms', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('type');
            $table->string('title');
            $table->integer('citizen_id');
            $table->integer('project_id')->default('1');
            $table->integer('sent_type');
              $table->integer('category_id')->nullable();
            $table->integer('account_id')->nullable();
            $table->integer('status');
             $table->longText('content');
            $table->date('datee');
             $table->integer('read')->nullable();
            
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
        Schema::dropIfExists('forms');
    }
}
