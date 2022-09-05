<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Realty\Models\Ad;

return new class() extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ads', function (Blueprint $table) {
            $table->id();
            $table->string('status')->default(Ad::STATUSES['PENDING_APPROVAL']);
            $table->unsignedBigInteger('user_id')->unsigned();
            $table->unsignedBigInteger('category_id')->unsigned();
            $table->string('coordinates');
            $table->float('price', 8, 2, true);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('ad_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('ad_id')->unsigned();
            $table->string('locale')->index();
            $table->string('caption');
            $table->text('description');
            $table->string('city');

            $table->unique(['ad_id', 'locale']);
            $table->foreign('ad_id')->references('id')->on('ads')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ad_translations');
        Schema::dropIfExists('ads');
    }
};
