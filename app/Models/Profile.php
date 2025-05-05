<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Profile extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'name',
        'surname',
        'country',
        'city',
        'phone',
    ];

    /**
     * Relación 1:1 con el modelo User.
     *  -   Un perfil pertenece a un usuario.
     *  -   Un usuario puede tener un perfil.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
