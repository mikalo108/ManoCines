<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Time extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'film_id',
        'room_id',
        'time',
    ];

    /**
     * Relacion N:N inversa con el modelo Film
     *  -   Un horario es la relación entre a una sala y una película.
     */
    public function film()
    {
        return $this->belongsTo(Film::class);
    }

    /**
     * Relacion N:N inversa con el modelo Room
     *  -   Un horario es la relación entre a una sala y una película.
     */
    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}
