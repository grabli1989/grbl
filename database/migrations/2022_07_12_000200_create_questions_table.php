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
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_set_id')->constrained('property_sets', 'id')->cascadeOnUpdate()->cascadeOnDelete();
            $table->unsignedBigInteger('relate_property_id')->nullable();
            $table->string('type');
            $table->string('slug');
            $table->boolean('show_name');
            $table->timestamps();
        });

        Schema::create('question_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('question_id')->unsigned();
            $table->string('locale')->index();
            $table->string('name');

            $table->unique(['question_id', 'locale']);
            $table->foreign('question_id')->references('id')->on('questions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('question_translations');
        Schema::dropIfExists('questions');
    }
};
