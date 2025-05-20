<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Database\Seeders\IncomeCatagorySeeder;
use Database\Seeders\ExpenseCatagorySeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            "first_name" => "brahim",
            "last_name" => "alhiane",
            "email" => "brahim@gmail.com",
            "password" => Hash::make("123123123"),
        ]);
        
        $this->call([
            IncomeCategorySeeder::class,
            ExpenseCategorySeeder::class,
        ]);
    }
}
