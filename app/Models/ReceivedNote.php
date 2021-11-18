<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReceivedNote extends Model
{
    use HasFactory;

    protected $fillable = [
      'manager_id',
      'deliver_name',
      'status',
      'receive_at',
      'note',
  ];

    protected $casts = [
      'status' => 'integer',
  ];

    protected $appends = [
      'total_price',
  ];

    public function getTotalPriceAttribute()
    {
        return $this->products->sum(function ($item) {
            return $item->pivot->price * $item->pivot->quantity;
        });
    }

    public function scopeOfType($query, $filter)
    {
        if (isset($filter['status']) && $filter['status'] !== 'all') {
            $query->where('status', $filter['status']);
        }

        return $query;
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'manager_id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'received_note_product', 'received_note_id', 'product_id')->withPivot('quantity', 'price')->withTimestamps();
    }
}
