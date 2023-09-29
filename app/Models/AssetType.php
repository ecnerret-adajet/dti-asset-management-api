<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'remarks',
        'is_active'
    ];

    /**
     * Scope
     */

     public function scopeFilter($query, array $filters)
     {
        $query->where($filters['name'] ?? null, function($query, $name) {
            $query->where('name','like','%'.$name.'%');
        });
     }
}
