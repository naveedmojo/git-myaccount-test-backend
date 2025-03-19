<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SubCategory;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
class SubCategorySeeder extends Seeder
{
    public function run(): void
    {
       
        SubCategory::insert([
            [
                'name' => 'Consoles',
                'main_category_id' => 1, // Assuming 1 = PS4
                'stock' => 10,
                'description' => 'PS4 Consoles',
                'image' => 'ps4_console.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Games',
                'main_category_id' => 1, // PS4
                'stock' => 50,
                'description' => 'PS4 Games',
                'image' => 'ps4_games.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Accessories',
                'main_category_id' => 1, // PS5
                'stock' => 20,
                'description' => 'PS4 Accessories',
                'image' => 'ps4_accessories.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Consoles',
                'main_category_id' => 2, // Assuming 1 = PS4
                'stock' => 10,
                'description' => 'PS5 Consoles',
                'image' => 'ps5_console.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Games',
                'main_category_id' => 2, // PS4
                'stock' => 50,
                'description' => 'PS5 Games',
                'image' => 'ps5_games.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Accessories',
                'main_category_id' => 2, // PS5
                'stock' => 20,
                'description' => 'PS5 Accessories',
                'image' => 'ps5_accessories.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
