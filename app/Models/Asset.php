<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Asset extends Model implements Auditable
{
    use HasFactory, SoftDeletes;

    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'image_path',
        'name',
        'description',
        'model',
        'serial_number',
        'purchase_date',
        'current_value',
        'manufacturer',
        'location_id',
        'asset_type_id',
        'status_id',
        'unit_price',
        'supplier_id',
        'import_price',
        'local_price',
    ];

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

    public function orders()
    {
        return $this->belongsToMany(Order::class)
            ->withPivot('qty','unit_price','total_amount')
            ->withTimestamps();
    }

    public function receivings()
    {
        return $this->hasMany(Receiving::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
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
            $query->whereIn('location_id', $location);
        })->when($filters['asset_type'] ?? null, function ($query, $asset_type) {
            $query->whereIn('asset_type_id', $asset_type);
        });
    }
}
