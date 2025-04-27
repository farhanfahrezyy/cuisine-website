<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'payment_id',
        'recipe_id',
        'price',
    ];

    /**
     * Get the payment that owns the payment item
     */
    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }

    /**
     * Get the recipe associated with the payment item
     */
    public function recipe()
    {
        return $this->belongsTo(Recipe::class);
    }
}