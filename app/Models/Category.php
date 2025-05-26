<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Cviebrock\EloquentSluggable\Sluggable;

class Category extends Model
{
    /** @use HasFactory<\Database\Factories\CategoryFactory> */
    use HasFactory, Sluggable;

    protected $table = 'categories';

    protected $fillable = [
        'category_name',
        'main_image',
    ];

    public function getImageUrlAttribute()
    {
        return $this->main_image ? Storage::url($this->main_image) : null;
    }

    /**
     * Eliminar imagen al eliminar categoría
     */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($category) {
            if ($category->main_image) {
                Storage::delete($category->main_image);
            }
        });
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'category_name',
                'onUpdate' => true,
                'unique' => true,
                'uniqueSuffix' => '-:id', // Ej: categoria-1, categoria-2
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

    public function products()
    {
        return $this->hasMany(Product::class, 'fk_category_id');
    }
}
