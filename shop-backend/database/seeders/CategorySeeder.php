<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        DB::table('categories')->insert([
            ['name' => 'PlayStation 4', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'PlayStation 5', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ]);
    }
}
