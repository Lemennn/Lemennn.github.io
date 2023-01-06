<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('username')->after('email');
            $table->bigInteger('phone')->after('email')->nullable();
            $table->string('roles')->after('email')->default('user');
            $table->string('address')->after('email')->nullable();
            $table->text('feedback_id')->after('email')->nullable();
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
            $table->bigInteger('phone');
            $table->string('roles');
            $table->string('address');
        });
    }
};
