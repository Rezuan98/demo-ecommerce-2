<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Size;
use Illuminate\Support\Str;

class SizeSeeder extends Seeder
{
    public function run(): void
    {
        $sizes = ['XS', 'S', 'M', 'L', 'XL', 'XXL', '30ml', '50ml', '100ml', '200ml'];

        foreach ($sizes as $size) {
            Size::updateOrCreate(
                ['slug' => Str::slug($size)],
                [
                    'name' => $size,
                    'status' => 1,
                ]
            );
        }
    }
}
