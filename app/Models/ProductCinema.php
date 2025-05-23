<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductCinema extends Model
{
    protected $table = 'cinemas_products';

    protected $fillable = [
        'cinema_id',
        'product_id',
    ];
}
