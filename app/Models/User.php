<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'email_verified_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
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
        'password' => 'hashed',
    ];
    
    /**
     * Relación 1:1 con el modelo Profile
     *  - Un usuario tiene un perfil
     *  - Un perfil pertenece a un usuario
     */
    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    /** 
     * Relación 1:N con el modelo Order
     *   - Un usuario puede realizar muchos pedidos
     *   - Una orden pertenece a un usuario
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
