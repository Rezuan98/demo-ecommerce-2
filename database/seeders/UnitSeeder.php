<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Unit;
use Illuminate\Support\Str;

class UnitSeeder extends Seeder
{
    public function run(): void
    {
        $units = ['Piece', 'Box', 'Set', 'Bottle', 'Tube', 'Jar', 'Pack', 'Pair'];

        foreach ($units as $unit) {
            Unit::updateOrCreate(
                ['slug' => Str::slug($unit)],
                [
                    'name' => $unit,
                    'status' => 1,
                ]
            );
        }
    }
}
