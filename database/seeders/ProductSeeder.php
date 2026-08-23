<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'name' => 'iPhone 13',
                'description' => 'iPhone 13',
                'price' => 1000,
                'category_id' => 1,
                'store_id' => 1,
            ],
            [
                'name' => 'إكسسوارات',
                'description' => 'إكسسوارات التقنية',
                'price' => 1200,
                'category_id' => 1,
                'store_id' => 2,
            ],
            [
                'name' => 'iPhone 15',
                'description' => 'iPhone 15',
                'price' => 1400,
                'category_id' => 1,
                'store_id' => 1,
            ],
            [
                'name' => 'iPhone 16',
                'description' => 'iPhone 16',
                'price' => 1600,
                'category_id' => 1,
                'store_id' => 1,
            ],
            [
                'name' => 'iPhone 17',
                'description' => 'iPhone 17',
                'price' => 1800,
                'category_id' => 1,
                'store_id' => 1,
            ],
            [
                'name' => 'ساعة ذكية',
                'description' => 'ساعة ذكية متطورة',
                'price' => 2000,
                'category_id' => 1,
                'store_id' => 2,
            ],
        ];

        foreach ($products as $item) {
            Product::query()->updateOrCreate(
                ['name' => $item['name']],
                [
                    'description' => $item['description'],
                    'price' => $item['price'],
                    'category_id' => $item['category_id'],
                    'store_id' => $item['store_id'],
                    'status' => 'active',
                ]
            );
        }
    }
}
