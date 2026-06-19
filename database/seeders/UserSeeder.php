<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        User::create([
             'name' => 'Muhammed',
             'email'=>'muhammeedvelid41@gmail.com',
             'password' => Hash::make('muhammed1990'),
            //Hash
            //bcrypt

            // 'password' => bcrypt('muhammed1990') // bcrypt
            //incrtpt
        ]);

        User::create([
            'name' => 'ali',
            'email' => 'ali@example.com',
            'password' => Hash::make('ali1990'),
            //Hash
            //bcrypt

            // 'password' => bcrypt('muhammed1990') // bcrypt
            //incrtpt
        ]);

        DB::table('users')->insert([
            'name' => 'ahmed',
            'email' => 'ahmed@example.com',
            'password' => Hash::make('ahmed1990'),
        ]);
    }
}
