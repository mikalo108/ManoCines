<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductCinema extends Model
{
    protected $table = 'product_cinemas';

    protected $fillable = [
        'product_id',
        'cinema_id',
    ];
}
