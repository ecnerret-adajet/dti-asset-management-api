<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'email',
        'phone_number',
        'representative_name',
    ];

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
