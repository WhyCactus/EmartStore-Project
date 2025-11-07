<?php

namespace Database\Seeders;

use Attribute;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AttributeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $attributes = [
            [
                'name' => 'Color',
                'options' => ['Black', 'Blue', 'Silver', 'Gold']
            ],
            [
                'name' => 'Storage',
                'options' => ['64GB', '128GB', '256GB', '512GB']
            ]
        ];

        $this->command->info('Attribute added successfully');
    }
}
