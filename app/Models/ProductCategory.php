<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    use HasFactory;

    protected $table = 'products_categories';

    protected $fillable = [
        'name',
    ];

    /**
     * Relación 1:N con el modelo Product.
     *  -   Una categoría de producto puede tener muchos productos.
     *  -   Un producto pertenece a una categoría de producto.
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
