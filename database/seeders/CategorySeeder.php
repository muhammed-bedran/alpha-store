<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;
class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $categories= [
            [
                'name'=> 'إلكترونيات',
                'description'=> 'أجهزة إالكترونية وهواتف وحواسيب تقنية',
             
            ],
            [
                'name'=> 'ملابس رجالية ونسائية',
                'description'=> ' ملابس رجالية ونسائية',
            ],
            [
                'name'=> 'مواد غذائية',
                'description'=> 'مواد غذائية',
            ],

            [
                'name'=> 'مواد صحية',
                'description'=> 'مواد صحية',
            ],
            [
                'name'=>'رياضة',
                'description'=>'رياضة',
            ]
        ];
        foreach($categories as $index=> $item)
            {
                $category = new Category();
                $category->name = $item['name'];
                $slug = Str::slug($item['name']);
                $category->slug = $slug !== '' ? $slug : 'category-'.($index+1);
                $category->description = $item['description'];
                $category->status = 'active';
                $category->save();

            }
    }
}
