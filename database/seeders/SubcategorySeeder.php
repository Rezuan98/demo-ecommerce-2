<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Support\Str;

class SubcategorySeeder extends Seeder
{
    public function run(): void
    {
        $subcategories = [
            'Skincare' => ['Moisturizers', 'Cleansers', 'Serums', 'Sunscreen', 'Face Masks'],
            'Makeup' => ['Foundation', 'Lipstick', 'Mascara', 'Eyeshadow', 'Blush'],
            'Hair Care' => ['Shampoo', 'Conditioner', 'Hair Oil', 'Hair Mask', 'Styling'],
            'Fragrance' => ['Perfume', 'Body Mist', 'Attar'],
            'Body Care' => ['Body Lotion', 'Body Wash', 'Scrubs', 'Hand Cream'],
            'Accessories' => ['Brushes', 'Sponges', 'Organizers'],
        ];

        foreach ($subcategories as $categoryName => $subs) {
            $category = Category::where('slug', Str::slug($categoryName))->first();
            if (!$category) {
                continue;
            }

            foreach ($subs as $sub) {
                Subcategory::updateOrCreate(
                    ['slug' => Str::slug($sub), 'category_id' => $category->id],
                    [
                        'name' => $sub,
                        'status' => 1,
                    ]
                );
            }
        }
    }
}
