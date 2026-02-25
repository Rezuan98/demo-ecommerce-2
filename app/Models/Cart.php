<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;




    protected $fillable = [
        'user_id',
        'product_id',
        'varient_id',
        'quantity',
        'price'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function variant()
    {
        // Explicitly define all parameters
        return $this->belongsTo(
            ProductVarient::class,    // Related model
            'varient_id',            // Foreign key on carts table
            'id',                    // Local key on product_varients table
            'variant'                // Relation name
        );
    }

}
