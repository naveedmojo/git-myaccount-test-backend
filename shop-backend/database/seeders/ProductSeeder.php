<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Get category IDs
        $ps4CategoryId = DB::table('categories')->where('name', 'PlayStation 4')->value('id');
        $ps5CategoryId = DB::table('categories')->where('name', 'PlayStation 5')->value('id');

        DB::table('products')->insert([
            [
                'name' => 'Sony PlayStation 4 Console',
                'category_id' => $ps4CategoryId,
                'price' => 17000,
                'stock' => 10,
                'edition' => 'Slim',
                'description' => 'A powerful gaming console by Sony.',
                'image' => 'products/ps4_slim.jpeg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Sony PlayStation 5 Console',
                'category_id' => $ps5CategoryId,
                'price' => 35000,
                'stock' => 15,
                'edition' => 'Slim',
                'description' => 'Next-gen gaming console by Sony.',
                'image' => 'products/ps5_slim.jpeg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
