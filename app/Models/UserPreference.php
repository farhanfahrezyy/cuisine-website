<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserPreference extends Model
{
    protected $table = 'user_preferences';
    protected $fillable = ['users', 'country', 'primary_ingredient', 'secondary_ingredient', 'spiciness'];

    public function recipes()
    {
        return $this->hasMany(Recipe::class);
    }
}
