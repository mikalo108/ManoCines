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

    public function cinema()
    {
        return $this->belongsTo(Cinema::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
