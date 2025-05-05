<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Time;
use Illuminate\Database\Eloquent\SoftDeletes;

class Film extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'image',
        'overview',
        'trailer',
    ];

    /**
     * Relación 1:N con el modelo Time
     *  - Una película puede tener muchos horarios.
     *  - Un horario pertenece a una película.
     */
    public function times()
    {
        return $this->hasMany(Time::class);
    }
}
