<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'is_active'
    ];

    /**
     * Asset relationship
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
}
