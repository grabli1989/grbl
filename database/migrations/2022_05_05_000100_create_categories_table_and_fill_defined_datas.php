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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->integer('position')->nullable();
        });

        Schema::create('category_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('category_id')->unsigned();
            $table->string('locale')->index();
            $table->string('name');

            $table->unique(['category_id', 'locale']);
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
        });

        $this->postUp();
    }

    private function postUp()
    {
        $definedCategoriesParams = \Realty\Interfaces\CategoriesNamesInterface::CATEGORIES;
        $i = 1;
        foreach ($definedCategoriesParams as $params) {
            $category = new \Realty\Models\Category();
            $category->position = $i;
            foreach ($params['name'] as $lang => $name) {
                $category->translateOrNew($lang)->name = $name;
            }
            $category->save();

            $category->addMedia(public_path($params['previewPath']))
                ->preservingOriginal()
                ->toMediaCollection('categories');
            $i++;
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('category_translations');
        Schema::dropIfExists('categories');
    }
};
