<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('orders', function (Blueprint $table) {
      $table->charset = 'utf8mb4';
      $table->collation = 'utf8mb4_unicode_ci';

      $table->id();
      $table->unsignedBigInteger('customer_id');
      $table->unsignedBigInteger('employee_id');
      $table->string('detail');
      $table->tinyInteger('status'); //0: chưa giao, 1: đang giao, 2: đã giao, 3: đã hủy
      $table->string('shipping_code', 50);

      $table->timestamps();

      $table->foreign('customer_id')->references('id')->on('users');
      $table->foreign('employee_id')->references('id')->on('users');

    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('orders');
  }
}
