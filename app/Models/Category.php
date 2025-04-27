<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;


    protected $table = 'categories';
    protected $fillable = ['category'];


    // Relasi ke model Product
    public function recipe()
    {
        return $this->hasMany(Recipe::class);
    }
}
