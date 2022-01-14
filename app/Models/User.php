<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;

    use HasFactory;

    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'email',
        'last_name',
        'first_name',
        'phone_number',
        'password',
        'role',
    ];

    protected $casts = [
        'role'=> 'integer',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * @var string[]
     */
    protected $appends = ['full_name'];

    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function has_orders()
    {
        return $this->hasMany(Order::class, 'customer_id');
    }

    public function created_orders()
    {
        return $this->hasMany(Order::class, 'employee_id');
    }

    public function scopeOfType($query, $filter)
    {
        if (!empty($filter['email'])) {
            $query->where('email', 'LIKE', '%' . $filter['email'] . '%');
        }

        return $query;
    }
}
