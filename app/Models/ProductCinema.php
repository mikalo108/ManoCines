<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductCinema extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'products_cinema';

    protected $fillable = [
        'product_id',
        'cinema_id',
        'quantity',
    ];
}
