<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    public function up()
    {
        Schema::create('user_infos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('first_name')->default('');
            $table->string('last_name')->default('');
            $table->string('middle_name')->default('');
        });
        $this->postUp();
    }

    private function postUp()
    {
        \User\Models\User::all()->each->createInfo();
    }

    public function down()
    {
        Schema::dropIfExists('user_infos');
    }
};
