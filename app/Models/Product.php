<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProductVarient;
use App\Models\GalleryImage;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_name',
        'slug',
        'product_image',
        'product_code',
        'category_id',
        'subcategory_id',
        'brand_id',
        'unit_id',
        'discount_type',
        'discount_amount',
        'tags',
        'sale_price',
        'description',
        'status',
        'featured',
    ];


    // Define relationships
    public function getTotalStockAttribute()
    {
        // Check if the sum was already loaded via withSum()
        if (array_key_exists('variants_sum_stock_quantity', $this->attributes)) {
            return $this->attributes['variants_sum_stock_quantity'] ?? 0;
        }

        // Fallback: sum from the relationship if loaded
        if ($this->relationLoaded('variants')) {
            return $this->variants->sum('stock_quantity');
        }

        // Last resort: load variants and sum (will cause extra query)
        return $this->variants()->sum('stock_quantity');
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function variants()
    {
        return $this->hasMany(ProductVarient::class);
    }

    public function galleryImages()
    {
        return $this->hasMany(GalleryImage::class);
    }

    public function orderItems()  // Note the name is orderItems, not Items
    {
        return $this->hasMany(OrderItem::class);
    }
}
