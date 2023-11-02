<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class Customer extends Model implements Auditable
{
    use HasFactory;

    use AuditableTrait;

    protected $fillable = [
        'name',
        'address',
        'email',
        'phone_number',
        'representative_name',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Scope
     */
    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['name'] ?? null, function($query, $name) {
            $query->where('name','like','%'.$name.'%');
        });
    }
}
