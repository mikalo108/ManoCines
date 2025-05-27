<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Cinema;
use App\Models\Time;
use Illuminate\Database\Eloquent\SoftDeletes;

class Room extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'number',
        'capacity',
    ];

    /**
     * Relación 1:N con el modelo Cinema
     *  -   Un cine puede tener varias salas.
     *  -   Una sala pertenece a un cine.
     */
    public function cinemas()
    {
        return $this->hasMany(Cinema::class, 'cinemas_rooms');
    }

    /**
     * Relación 1:N con el modelo Time
     *  -   Una sala puede tener varios horarios.
     *  -   Un horario pertenece a una sala.
     */
    public function times()
    {
        return $this->hasMany(Time::class);
    }

    /**
     * Relación 1:N con el modelo Chair
     */
    public function chairs(){
        return $this->hasMany(Chair::class);
    }
}
