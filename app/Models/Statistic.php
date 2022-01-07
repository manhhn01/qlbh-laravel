<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Statistic extends Model
{
    use HasFactory;

    protected $fillable = ['order_total', 'product_total', 'proceeds'];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('d/m');
    }

    protected $hidden = ['updated_at', 'id', 'product_total'];
}
