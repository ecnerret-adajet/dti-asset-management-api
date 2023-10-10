<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'customer_id',
        'order_status_id',
        'total_cost',
        'total_orders',
        'remarks',
    ];

    /**
     * relationshio
     */
    public function assets()
    {
        return $this->belongsToMany(Asset::class)
            ->withPivot('qty','unit_price','total_amount')
            ->withTimestamps();
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
