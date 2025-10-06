<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $brands = [
            [
                'brand_name' => 'Apple',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'brand_name' => 'Samsung',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'brand_name' => 'Xiaomi',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('brands')->insert($brands);
    }
}
