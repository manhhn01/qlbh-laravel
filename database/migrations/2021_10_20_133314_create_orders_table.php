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
      $table->unsignedBigInteger('customer_email')->nullable(); //null: khách hàng mua tại của hàng không cần đk tk như mua online
      $table->unsignedBigInteger('employee_id');
      $table->tinyInteger('buy_place'); //0: online, 1: offline
      $table->tinyInteger('status'); //0: đang chuẩn bị, 1: đang giao, 2: đã giao, 3: đã hủy
      $table->tinyInteger('payment_method'); //0 Chuyển khoản, 1 thanh toán khi nhận hàng, 2 thanh toán tại của hàng.
      $table->unsignedBigInteger('coupon_id')->nullable(); //mã giảm
      $table->string('deliver_to')->nullable(); //địa chỉ nhận hàng
      $table->string('note')->nullable();

      $table->timestamps();

      $table->foreign('employee_id')->references('id')->on('users');
      $table->foreign('coupon_id')->references('id')->on('coupons');

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
