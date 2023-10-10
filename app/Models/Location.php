<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'remarks',
        'is_active'
    ];

    /**
     * asset relationship
     */
    public function assets()
    {
        return $this->hasMany(Asset::class);
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

    /**
     * Active locations
     */
    public function scopeActiveLocations($query)
    {
        $query->where('is_active',1);
    }
}
