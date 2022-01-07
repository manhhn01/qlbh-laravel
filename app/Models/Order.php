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
        'note',
    ];

    protected $casts = [
        'status'=> 'integer',
    ];

    protected $appends = [
        'total_price',
        'discount_amount',
    ];

    public function getTotalPriceAttribute()
    {
        $total = $this->sumPrice();
        if (isset($this->coupon)) {
            return $total * (100 - $this->coupon->discount) / 100;
        }

        return $total;
    }

    public function getTotalProductAttribute()
    {
        return $this->products->sum(function ($item) {
            return $item->pivot->quantity;
        });
    }

    public function getDiscountAmountAttribute()
    {
        if (isset($this->coupon)) {
            return $this->sumPrice() * $this->coupon->discount / 100;
        } else {
            return 0;
        }
    }

    public function sumPrice()
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

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_email', 'email');
    }

    public function employee()
    {
        return $this->belongsTo(User::class, 'employee_id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_product', 'order_id', 'product_id')->withPivot('quantity', 'price')->withTimestamps();
    }

    public function coupon()
    {
        return $this->hasOne(Coupon::class, 'id', 'coupon_id');
    }
}
