<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;


    protected $fillable = [
        'name',
        'discount',
        'remain',
        'expire_at',
        'description',
    ];

    protected $appends = [
        'is_usable'
    ];

    public function getIsUsableAttribute(){
        return strtotime($this->expire_at) >= strtotime(date("Y-m-d"));
    }
}
