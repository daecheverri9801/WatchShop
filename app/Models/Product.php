<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory, Sluggable;

    protected $table = 'products';

    protected $fillable = [
        'fk_category_id',
        'product_name',
        'product_ref',
        'fk_brand_id',
        'genre',
        'fk_color_id',
        'fk_material_id',
        'uv_protection',
        'water_resistance',
        'size',
        'price',
        'main_image',
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'product_ref',
                'onUpdate' => true,
                'unique' => true,
                'uniqueSuffix' => '-:id', // Ej: producto-1, producto-2
                'maxLength' => 100,
                'maxLengthKeepWords' => true,
                'method' => function ($string, $separator) {
                    // Personalización adicional si es necesario
                    return Str::slug($string, $separator);
                },
            ]
        ];
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function getImageUrlAttribute()
    {
        return $this->image ? Storage::url($this->image) : null;
    }

    /**
     * Eliminar imagen al eliminar categoría
     */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($product) {
            if ($product->image) {
                Storage::delete($product->image);
            }
        });
    }

    /**
     * Relación con la tabla categories
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'fk_category_id');
    }
    /**
     * Relación con la tabla brands
     */
    public function brand()
    {
        return $this->belongsTo(Brand::class, 'fk_brand_id');
    }
    /**
     * Relación con la tabla colors
     */
    public function color()
    {
        return $this->belongsTo(Color::class, 'fk_color_id');
    }
    /**
     * Relación con la tabla materials
     */
    public function material()
    {
        return $this->belongsTo(Material::class, 'fk_material_id');
    }
}
