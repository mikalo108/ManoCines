<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'image',
        'price',
        'category',
        'product_category_id',
    ];

    /**
     * Relación N:N con el modelo Cinema.
     *  -   Un producto puede estar en muchos cines.
     *  -   Un cine puede tener muchos productos.
     */
    public function cinemas()
    {
        return $this->belongsToMany(Cinema::class, 'products_cinema');
    }

    /**
     * Relación 1:N con el modelo ProductCategory.
     *  -   Un producto pertenece a una categoría de producto.
     *  -   Una categoría de producto puede tener muchos productos.
     */
    public function category()
    {
        return $this->belongsTo(ProductCategory::class);
    }
}
