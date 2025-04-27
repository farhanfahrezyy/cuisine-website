<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Recipe extends Model
{
    protected $table = 'recipes';

    protected $fillable = [
        'category_id',
        'name',
        'price',
        'instructions',
        'image',
        'country',
        'detail',
        'ingredients',
        'spiciness',
        'premium',
        'preferences_id',
    ];

    protected $casts = [
        'instructions' => 'json', // Casting ke JSON
        'ingredients' => 'json', // Casting ke JSON
        'price' => 'decimal:2',  // Casting harga ke format desimal
        'premium' => 'boolean',  // Casting premium ke boolean untuk logika
    ];

    // Aksesors untuk harga berdasarkan status premium
    public function getDisplayPriceAttribute()
    {
        return $this->price === 0 ? 'Gratis' : 'Rp ' . number_format($this->price, 2, ',', '.');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function preference()
    {
        return $this->belongsTo(UserPreference::class, 'user_preference_id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }


}
