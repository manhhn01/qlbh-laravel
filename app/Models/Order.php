<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
  use HasFactory;

//  function test(){
//    $order = new Order();
//    $order->products()->attach(1, 100, 100000);
//  }
  /**
   * The attributes that are mass assignable.
   *
   * @var string[]
  protected $fillable = [
    'customer_id',
    'employee_id',
    'detail',
    'status',
    'shipping_code'
  ];
   */

  public function customer()
  {
    return $this->belongsTo(User::class, 'customer_id');
  }

  public function employee()
  {
    return $this->belongsTo(User::class, 'employee_id');
  }

  public function products(){
    return $this->belongsToMany(Product::class, 'order_product', 'order_id', 'product_id')->withPivot('quantity', 'price');
  }
}
