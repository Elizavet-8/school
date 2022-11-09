<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('tests', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->unsignedInteger('order')->nullable();
            $table->unsignedInteger('minutes');
            $table->unsignedInteger('min_correct');
            $table->unsignedInteger('section_id')->nullable();
            $table->boolean("is_required")->default(0);
            $table->foreignId('theme_id')->constrained()->onUpdate('cascade')
                ->onDelete('cascade');
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tests');
    }
}
