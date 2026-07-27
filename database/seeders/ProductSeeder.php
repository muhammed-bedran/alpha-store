<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Store;
use App\Models\Product;
class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $categories = Category::query()->pluck('id','name');
        $stores = Store::query()->pluck('id','name');
        if($categories->isEmpty() || $stores->isEmpty()){
            $this->command?->warn('No categories or stores found. Please run the category and store seeder first.');
            return;
        }
        $products = [
            [
                'name' => 'iPhone 13',
                'description' => 'iPhone 13',
                'price' => 1000,
                'category' => 'إلكترونيات',
                'store' => 'متجر التقنية',
            ],
            [
                'name' => 'إكسسوارات',
                'description' => 'إكسسوارات التقنية',
                'price' => 1200,
                'category' => 'إلكترونيات',
                'store' => 'متجر ستايل',
            ],
            [
                'name' => 'iPhone 15',
                'description' => 'iPhone 15',
                'price' => 1400,
                'category' => 'إلكترونيات',
                'store' => 'متجر التقنية',
            ],
            [
                'name' => 'iPhone 16',
                'description' => 'iPhone 16',
                'price' => 1600,
                'category' => 'إلكترونيات',
                'store' => 'متجر التقنية',
            ],
            [
                'name' => 'iPhone 17',
                'description' => 'iPhone 17',
                'price' => 1800,
                'category' => 'إلكترونيات',
                'store' => 'متجر التقنية',
            ],
            [
                'name' => 'ساعة ذكية',
                'description' => 'iPhone 18',
                'price' => 2000,
                'category' => 'إلكترونيات',
                'store' => 'متجر ستايل',
            ]
        ];
        foreach($products as $item)
            {
                Product::create([
                    'name' => $item['name'],
                    'description' => $item['description'],
                    'price' => $item['price'],
                    'category_id' => $categories[$item['category']] ?? null,
                    'store_id' => $stores[$item['store']] ?? null
                ]);
            }


    }
}
