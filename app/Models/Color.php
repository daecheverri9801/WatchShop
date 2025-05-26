<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Color extends Model
{
    use HasFactory;

    protected $table = 'colors';

    protected $fillable = [
        'color_name',
        'color_hex',
    ];

    public function products()
    {
        return $this->hasMany(Product::class, 'fk_color_id');
    }
}
