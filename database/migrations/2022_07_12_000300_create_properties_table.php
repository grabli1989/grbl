<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->foreignId('question_id')->constrained('questions', 'id')->cascadeOnUpdate()->cascadeOnDelete();
            $table->unsignedInteger('position');
            $table->string('slug');
            $table->timestamps();
        });

        Schema::create('property_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('property_id')->unsigned();
            $table->string('locale')->index();
            $table->string('name');
            $table->string('value');

            $table->unique(['property_id', 'locale']);
            $table->foreign('property_id')->references('id')->on('properties')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('property_translations');
        Schema::dropIfExists('properties');
    }
};
