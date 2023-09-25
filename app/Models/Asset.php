<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Asset extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function assetType()
    {
        return $this->belongsTo(AssetType::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    /**
     * Scope
     */

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['name'] ?? null, function ($query, $name) {
            $query->where('name', 'like', '%'.$name.'%');
        })->when($filters['model'] ?? null, function ($query, $model) {
            $query->where('model', 'like', '%'.$model.'%');
        })->when($filters['serial_number'] ?? null, function ($query, $serial_number) {
            $query->where('serial_number', 'like', '%'.$serial_number.'%');
        })->when($filters['location'] ?? null, function ($query, $location) {
            $query->where('location_id', $location);
        });
    }
}
