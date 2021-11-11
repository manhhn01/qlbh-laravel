<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */

    protected $fillable = [
        'customer_email',
        'employee_id',
        'buy_place',
        'payment_method',
        'status',
        'coupon_id',
        'deliver_to',
        'note'
    ];

    protected $appends = [
        'total_price'
    ];

    public function getTotalPriceAttribute()
    {
        if (isset($this->coupon)) {
            return $this->orderProducts->sum('pivot.price') * (100 - $this->coupon->discount) / 100;
        }
        return $this->orderProducts->sum('pivot.price');
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function employee()
    {
        return $this->belongsTo(User::class, 'employee_id');
    }

    public function orderProducts()
    {
        return $this->belongsToMany(Product::class, 'order_product', 'order_id', 'product_id')->withPivot('quantity', 'price')
            ->withTimestamps();
    }

    public function coupon()
    {
        return $this->hasOne(Coupon::class, 'id', 'coupon_id');
    }
}
