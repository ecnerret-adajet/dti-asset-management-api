<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class Receiving extends Model implements Auditable
{
    use HasFactory;

    use AuditableTrait;

    protected $fillable = [
        'user_id',
        'asset_id',
        'qty',
        'receiving_status_id',
        'remarks',
        'is_added',
        'po_number',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }

    public function receivingStatus()
    {
        return $this->belongsTo(ReceivingStatus::class);
    }

    /**
     * scope
     */
    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['asset_name'] ?? null, function ($query, $asset_name) {
            $query->whereHas('asset', function($q) use ($asset_name) {
                $q->where('name', 'like', '%'.$asset_name.'%');
            });
        })->when($filters['receiving_status_id'] ?? null, function ($query, $receiving_status_id) {
            $query->whereHas('receivingStatus', function($q) use ($receiving_status_id) {
                $q->where('id', $receiving_status_id);
            });
        });
    }
}
