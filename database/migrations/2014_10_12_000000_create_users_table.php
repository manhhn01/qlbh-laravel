<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';

            $table->id();
            $table->string('email')->unique();
            $table->string('first_name', 50);
            $table->string('last_name', 50);
            $table->string('password', 70);
            $table->char('phone_number', 15)->nullable();
            $table->string('address')->nullable();
            $table->string('avatar_image')->nullable();
            $table->smallInteger('role'); // 0: manager, 1: employee, 2: customer
            $table->rememberToken();

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
        Schema::dropIfExists('users');
    }
}
