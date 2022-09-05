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
        Schema::table('users', function (Blueprint $table) {
            $table->string('name')->default('')->change();
            $table->string('email')->default('')->change();
            $table->dropUnique(['email']);
            $table->string('phone')->after('email');
            $table->unique('phone');
            $table->string('phone_confirmation_code')->after('phone');
            $table->boolean('is_confirmed')->default(0)->after('phone_confirmation_code');
            $table->timestamp('phone_verified_at')->nullable()->after('is_confirmed');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('name')->change();
            $table->string('email')->change();
            $table->unique(['email']);
            $table->dropColumn([
                'phone',
                'phone_confirmation_code',
                'is_confirmed',
                'phone_verified_at',
            ]);
        });
    }
};
