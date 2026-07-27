<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Store;
use App\Models\User;
class StoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $techStore = Store::create([
            'name' => 'متجر التقنية',
            'description' => 'متجر التقنية',
            'status' => 'active'
        ]);
        $styleStore = Store::create([
            'name' => 'متجر ستايل',
            'description' => 'متجر الاستيل',
            'status' => 'active'
        ]);
        User::query()->where('email', 'muhammeedvelid41@gmail.com')->update([
            'store_id' => $techStore->id
        ]);
        User::query()->where('email', 'ali@example.com')->update([
            'store_id' => $styleStore->id
        ]);
    }
}
