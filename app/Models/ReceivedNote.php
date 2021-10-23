<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReceivedNote extends Model
{
  use HasFactory;

  public function user()
  {
    return $this->belongsTo(User::class, 'manager_id');
  }

  public function supplier()
  {
    return $this->belongsTo(Supplier::class, 'supplier_id');
  }

  public function products()
  {
    return $this->belongsToMany(Product::class, 'received_note_product', 'received_note_id', 'product_id')->withPivot('quantity', 'price');
    //https://laravel.io/forum/04-08-2014-define-relationships-of-a-pivot-table-with-more-than-2-foreign-keys
  }

}
