<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class City extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
    ];

    // Relación 1:N con la tabla cinemas
    public function cinemas()
    {
        return $this->belongsToMany(Cinema::class, 'city_cinema');
    }
}
