<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCorrectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('corrects', function (Blueprint $table) {
            $table->id();
           // $table->integer('user_id')->unsigned();
            $table->integer('to_user_id')->unsigned();
            $table->string('body')->nullable();
            $table->string('correct')->nullable();
            $table->integer('correcttable_id')->unsigned();
            $table->string('correcttable_type');
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
        Schema::dropIfExists('corrects');
    }
}
