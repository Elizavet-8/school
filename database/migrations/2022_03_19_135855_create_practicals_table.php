<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePracticalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('practicals', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->unsigned();
            $table->unsignedInteger('section_id')->nullable();
            $table->boolean("is_required")->default(0);
            $table->foreignId('theme_id')->constrained()->onUpdate('cascade');
            $table->string('title')->nullable();
            $table->longText('purpose')->nullable();
            $table->longText('task')->nullable();
            $table->string('file')->nullable();
            $table->string('link')->nullable();
            $table->string('image')->nullable();
            $table->longText('recommendations')->nullable();
            $table->longText('criteria')->nullable();
            $table->longText('howtosend')->nullable();

            $table->longText('correct')->nullable();
            $table->string('correct_file')->nullable();
            $table->integer('to_user_id')->unsigned()->nullable();
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
        Schema::dropIfExists('practicals');
    }
}
