<?php

namespace Database\Seeders;

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
                'product_code' => 'IP13',
                'image' => 'https://images.unsplash.com/photo-1523275335684-37898b6c077c?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxzZWFyY2h8Mnx8aXBob25lJTIwMTN8ZW58MHx8MHx8&auto=format&fit=crop&w=500&q=60',
                'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quae, natus.',
                'original_price' => 1000,
                'discounted_price' => 800,
                'status' => 'active',
                'category_id' => 1,
                'brand_id' => 1,
                'quantity_in_stock' => 10,
                'sold_count' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_name' => 'Iphone 14',
                'product_code' => 'IP14',
                'image' => 'https://images.unsplash.com/photo-1523275335684-37898b6c077c?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxzZWFyY2h8Mnx8aXBob25lJTIwMTN8ZW58MHx8MHx8&auto=format&fit=crop&w=500&q=60',
                'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quae, natus.',
                'original_price' => 1000,
                'discounted_price' => 800,
                'status' => 'active',
                'category_id' => 1,
                'brand_id' => 1,
                'quantity_in_stock' => 10,
                'sold_count' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_name' => 'Iphone 15',
                'product_code' => 'IP15',
                'image' => 'https://images.unsplash.com/photo-1523275335684-37898b6c077c?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxzZWFyY2h8Mnx8aXBob25lJTIwMTN8ZW58MHx8MHx8&auto=format&fit=crop&w=500&q=60',
                'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quae, natus.',
                'original_price' => 1000,
                'discounted_price' => 800,
                'status' => 'active',
                'category_id' => 1,
                'brand_id' => 1,
                'quantity_in_stock' => 10,
                'sold_count' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_name' => 'Iphone 16',
                'product_code' => 'IP16',
                'image' => 'https://images.unsplash.com/photo-1523275335684-37898b6c077c?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxzZWFyY2h8Mnx8aXBob25lJTIwMTN8ZW58MHx8MHx8&auto=format&fit=crop&w=500&q=60',
                'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quae, natus.',
                'original_price' => 1000,
                'discounted_price' => 800,
                'status' => 'active',
                'category_id' => 1,
                'brand_id' => 1,
                'quantity_in_stock' => 10,
                'sold_count' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_name' => 'Samsung S21',
                'product_code' => 'SS21',
                'image' => 'https://images.unsplash.com/photo-1523275335684-37898b6c077c?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxzZWFyY2h8Mnx8aXBob25lJTIwMTN8ZW58MHx8MHx8&auto=format&fit=crop&w=500&q=60',
                'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quae, natus.',
                'original_price' => 1000,
                'discounted_price' => 800,
                'status' => 'active',
                'category_id' => 1,
                'brand_id' => 2,
                'quantity_in_stock' => 10,
                'sold_count' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_name' => 'Samsung S22',
                'product_code' => 'SS22',
                'image' => 'https://images.unsplash.com/photo-1523275335684-37898b6c077c?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxzZWFyY2h8Mnx8aXBob25lJTIwMTN8ZW58MHx8MHx8&auto=format&fit=crop&w=500&q=60',
                'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quae, natus.',
                'original_price' => 1000,
                'discounted_price' => 800,
                'status' => 'active',
                'category_id' => 1,
                'brand_id' => 2,
                'quantity_in_stock' => 10,
                'sold_count' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        DB::table('products')->insert($products);
    }
}
