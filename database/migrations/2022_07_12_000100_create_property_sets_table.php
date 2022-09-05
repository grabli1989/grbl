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
        Schema::create('property_sets', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
        });

        Schema::create('property_set_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('property_set_id')->unsigned();
            $table->string('locale')->index();
            $table->string('name');

            $table->unique(['property_set_id', 'locale']);
            $table->foreign('property_set_id')->references('id')->on('property_sets')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('property_set_translations');
        Schema::dropIfExists('property_sets');
    }
};
