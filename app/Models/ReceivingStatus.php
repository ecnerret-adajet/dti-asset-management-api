<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReceivingStatus extends Model
{
    use HasFactory;

    public function receivings()
    {
        return $this->hasMany(Receiving::class);
    }
}
