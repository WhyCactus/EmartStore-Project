<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'product_name' => 'Iphone 13',
                'sku' => 'IP13',
                'image' => 'products/iphone-13.jpg',
                'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quae, natus.',
                'original_price' => 650,
                'discounted_price' => 450,
                'status' => 'active',
                'category_id' => 1,
                'brand_id' => 1,
                'quantity_in_stock' => 10,
                'sold_count' => 10,
                'created_at' => Carbon::now()->subDays(1),
                'updated_at' => now(),
            ],
            [
                'product_name' => 'Iphone 14',
                'sku' => 'IP14',
                'image' => 'products/iphone-14.jpg',
                'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quae, natus.',
                'original_price' => 700,
                'discounted_price' => 550,
                'status' => 'active',
                'category_id' => 1,
                'brand_id' => 1,
                'quantity_in_stock' => 10,
                'sold_count' => 15,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_name' => 'Iphone 15',
                'sku' => 'IP15',
                'image' => 'products/iphone-15.jpg',
                'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quae, natus.',
                'original_price' => 950,
                'discounted_price' => 900,
                'status' => 'active',
                'category_id' => 1,
                'brand_id' => 1,
                'quantity_in_stock' => 10,
                'sold_count' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_name' => 'Iphone 16',
                'sku' => 'IP16',
                'image' => 'products/iphone-16.jpg',
                'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quae, natus.',
                'original_price' => 1000,
                'discounted_price' => 800,
                'status' => 'active',
                'category_id' => 1,
                'brand_id' => 1,
                'quantity_in_stock' => 10,
                'sold_count' => 7,
                'created_at' => Carbon::now()->subDays(1),
                'updated_at' => now(),
            ],
            [
                'product_name' => 'Samsung S21',
                'sku' => 'SS21',
                'image' => 'products/samsung-s21.jpg',
                'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quae, natus.',
                'original_price' => 700,
                'discounted_price' => 500,
                'status' => 'active',
                'category_id' => 1,
                'brand_id' => 2,
                'quantity_in_stock' => 10,
                'sold_count' => 23,
                'created_at' => Carbon::now()->subDays(2),
                'updated_at' => now(),
            ],
            [
                'product_name' => 'Samsung S22',
                'sku' => 'SS22',
                'image' => 'products/samsung-s22.jpg',
                'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quae, natus.',
                'original_price' => 850,
                'discounted_price' => 600,
                'status' => 'active',
                'category_id' => 1,
                'brand_id' => 2,
                'quantity_in_stock' => 10,
                'sold_count' => 11,
                'created_at' => Carbon::now()->subDays(3),
                'updated_at' => now(),
            ],
            [
                'product_name' => 'Apple Watch Series 10',
                'sku' => 'AW10',
                'image' => 'products/apple-watch-series-10.jpg',
                'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quae, natus.',
                'original_price' => 450,
                'discounted_price' => 300,
                'status' => 'active',
                'category_id' => 5,
                'brand_id' => 1,
                'quantity_in_stock' => 10,
                'sold_count' => 12,
                'created_at' => Carbon::now()->subDays(4),
                'updated_at' => now(),
            ],
            [
                'product_name' => 'Ipad A16',
                'sku' => 'IPA16',
                'image' => 'products/ipad-a16.jpg',
                'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quae, natus.',
                'original_price' => 550,
                'discounted_price' => 500,
                'status' => 'active',
                'category_id' => 2,
                'brand_id' => 1,
                'quantity_in_stock' => 10,
                'sold_count' => 8,
                'created_at' => Carbon::now()->subDays(5),
                'updated_at' => now(),
            ],
            [
                'product_name' => 'Macbook Air M2',
                'sku' => 'MBM2',
                'image' => 'products/mac-air-m2.jpg',
                'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quae, natus.',
                'original_price' => 800,
                'discounted_price' => 700,
                'status' => 'active',
                'category_id' => 3,
                'brand_id' => 1,
                'quantity_in_stock' => 10,
                'sold_count' => 25,
                'created_at' => Carbon::now()->subDays(4),
                'updated_at' => now(),
            ],
        ];

        DB::table('products')->insert($products);
    }
}
