<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
// use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    // use HasApiTokens, HasFactory, Notifiable, SoftDeletes;
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'first_name',
        'last_name',
        'image_path',
        'email',
        'contact_number',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * role relationship
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_role');
    }

    public function role()
    {
        return $this->hasOne(Role::class, 'user_role');
    }

    /**
     * Asset relationshipt
     */
    public function assets()
    {
        return $this->hasMany(Asset::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function receivings()
    {
        return $this->hasMany(Receiving::class);
    }

    /**
     * Scope
     */
    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['name'] ?? null, function($query, $name) {
            $query->where('name','like','%'.$name.'%');
        })->when($filters['role_name'] ?? null, function ($query, $role_name) {
            $query->whereHas('roles', function ($q) use ($role_name) {
                $q->where('name','like','%'.$role_name.'%');
            });
        });
    }
}
