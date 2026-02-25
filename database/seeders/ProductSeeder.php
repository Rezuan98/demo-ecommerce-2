<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVarient;
use App\Models\Size;
use App\Models\Subcategory;
use App\Models\Unit;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Fetch lookup data
        $categories = Category::pluck('id', 'slug');
        $subcategories = Subcategory::pluck('id', 'slug');
        $sizes = Size::pluck('id', 'slug');
        $units = Unit::pluck('id', 'slug');

        // Create a sample brand if none exists
        $brand = Brand::firstOrCreate(
            ['slug' => 'tazinic'],
            ['name' => 'Tazinic', 'status' => 1]
        );

        $products = [
            [
                'product_name' => 'Hydrating Face Serum',
                'sale_price' => 1200.00,
                'category' => 'skincare',
                'subcategory' => 'serums',
                'unit' => 'bottle',
                'description' => 'A lightweight, hydrating serum infused with hyaluronic acid and vitamin C to brighten and moisturize your skin.',
                'discount_type' => 'percentage',
                'discount_amount' => 10,
                'featured' => true,
                'tags' => 'serum,hydrating,vitamin-c,skincare',
                'sizes' => ['30ml' => 50, '50ml' => 30],
            ],
            [
                'product_name' => 'Matte Lipstick',
                'sale_price' => 650.00,
                'category' => 'makeup',
                'subcategory' => 'lipstick',
                'unit' => 'piece',
                'description' => 'Long-lasting matte lipstick with rich pigment and a smooth, velvety finish.',
                'discount_type' => null,
                'discount_amount' => null,
                'featured' => true,
                'tags' => 'lipstick,matte,makeup',
                'sizes' => ['s' => 100],
            ],
            [
                'product_name' => 'Keratin Hair Mask',
                'sale_price' => 950.00,
                'category' => 'hair-care',
                'subcategory' => 'hair-mask',
                'unit' => 'jar',
                'description' => 'Deep-conditioning keratin hair mask that repairs and strengthens damaged hair, leaving it silky smooth.',
                'discount_type' => 'fixed',
                'discount_amount' => 100,
                'featured' => false,
                'tags' => 'hair,mask,keratin,repair',
                'sizes' => ['100ml' => 40, '200ml' => 20],
            ],
            [
                'product_name' => 'Rose Body Mist',
                'sale_price' => 800.00,
                'category' => 'fragrance',
                'subcategory' => 'body-mist',
                'unit' => 'bottle',
                'description' => 'A refreshing rose-scented body mist for a light, everyday fragrance experience.',
                'discount_type' => 'percentage',
                'discount_amount' => 15,
                'featured' => true,
                'tags' => 'fragrance,body-mist,rose',
                'sizes' => ['100ml' => 60, '200ml' => 35],
            ],
            [
                'product_name' => 'Gentle Foaming Cleanser',
                'sale_price' => 550.00,
                'category' => 'skincare',
                'subcategory' => 'cleansers',
                'unit' => 'tube',
                'description' => 'A gentle foaming face cleanser suitable for all skin types. Removes impurities without stripping natural moisture.',
                'discount_type' => null,
                'discount_amount' => null,
                'featured' => false,
                'tags' => 'cleanser,foam,gentle,skincare',
                'sizes' => ['100ml' => 80, '200ml' => 45],
            ],
            [
                'product_name' => 'SPF 50 Sunscreen',
                'sale_price' => 750.00,
                'category' => 'skincare',
                'subcategory' => 'sunscreen',
                'unit' => 'tube',
                'description' => 'Broad-spectrum SPF 50 sunscreen with a lightweight, non-greasy formula perfect for daily use.',
                'discount_type' => 'percentage',
                'discount_amount' => 5,
                'featured' => true,
                'tags' => 'sunscreen,spf50,skincare,protection',
                'sizes' => ['50ml' => 70],
            ],
            [
                'product_name' => 'Volumizing Mascara',
                'sale_price' => 500.00,
                'category' => 'makeup',
                'subcategory' => 'mascara',
                'unit' => 'piece',
                'description' => 'High-definition volumizing mascara for dramatic, clump-free lashes that last all day.',
                'discount_type' => null,
                'discount_amount' => null,
                'featured' => false,
                'tags' => 'mascara,volume,makeup,lashes',
                'sizes' => ['s' => 90],
            ],
            [
                'product_name' => 'Nourishing Body Lotion',
                'sale_price' => 680.00,
                'category' => 'body-care',
                'subcategory' => 'body-lotion',
                'unit' => 'bottle',
                'description' => 'Rich body lotion with shea butter and aloe vera for deep hydration and soft, glowing skin.',
                'discount_type' => 'fixed',
                'discount_amount' => 80,
                'featured' => false,
                'tags' => 'lotion,body,nourishing,shea-butter',
                'sizes' => ['100ml' => 55, '200ml' => 30],
            ],
        ];

        $counter = 1;

        foreach ($products as $data) {
            $productCode = 'TZN-' . str_pad($counter, 4, '0', STR_PAD_LEFT);

            $product = Product::updateOrCreate(
                ['product_code' => $productCode],
                [
                    'product_name' => $data['product_name'],
                    'slug' => Str::slug($data['product_name']),
                    'product_image' => 'default.jpg',
                    'category_id' => $categories[$data['category']] ?? 1,
                    'subcategory_id' => $subcategories[$data['subcategory']] ?? null,
                    'brand_id' => $brand->id,
                    'unit_id' => $units[$data['unit']] ?? null,
                    'discount_type' => $data['discount_type'],
                    'discount_amount' => $data['discount_amount'],
                    'sale_price' => $data['sale_price'],
                    'description' => $data['description'],
                    'tags' => $data['tags'],
                    'status' => true,
                    'featured' => $data['featured'],
                ]
            );

            // Create variants (size + stock)
            foreach ($data['sizes'] as $sizeSlug => $stock) {
                $sizeId = $sizes[$sizeSlug] ?? null;
                if (!$sizeId) {
                    continue;
                }

                ProductVarient::updateOrCreate(
                    ['product_id' => $product->id, 'size_id' => $sizeId],
                    [
                        'stock_quantity' => $stock,
                        'sku' => $productCode . '-' . strtoupper($sizeSlug),
                        'status' => true,
                    ]
                );
            }

            $counter++;
        }
    }
}
