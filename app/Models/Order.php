<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Order extends Model implements Auditable
{
    use HasFactory, SoftDeletes;

    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'user_id',
        'customer_id',
        'order_status_id',
        'total_cost',
        'total_orders',
        'remarks',
        'order_reference',
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

    public function orderStatus()
    {
        return $this->belongsTo(OrderStatus::class);
    }

    /**
     * scope
     */
    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['asset_name'] ?? null, function ($query, $asset_name) {
            $query->whereHas('assets', function($q) use ($asset_name) {
                $q->where('name', 'like', '%'.$asset_name.'%');
            });
        })->when($filters['order_status_id'] ?? null, function ($query, $order_status_id) {
            if($order_status_id != null)  {
                $query->whereHas('orderStatus', function($q) use ($order_status_id) {
                    $q->where('id', $order_status_id);
                });
            }
        });
    }
}
