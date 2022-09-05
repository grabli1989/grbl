<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class() extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ad_has_properties', function (Blueprint $table) {
            $table->foreignId('property_id')->constrained('properties', 'id')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('ad_id')->constrained('ads', 'id')->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('value')->nullable();
            $table->index(['property_id', 'value'], 'ad_has_properties_property_id_value_index');
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
        Schema::dropIfExists('ad_has_properties');
    }
};
