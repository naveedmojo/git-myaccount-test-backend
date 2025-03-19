<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::insert([
            [
                'name' => 'PS4 DualShock Controller',
                'description' => 'Wireless controller for PS4',
                'price' => 49.99,
                'sub_category_id' =>3,
                'image' => 'ps4_controller.jpg',
                'is_sold' => false,
                'type' => 'New',
                'years_used' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'PS5 DualSense Controller',
                'description' => 'Advanced haptic feedback and adaptive triggers',
                'price' => 69.99,
                'sub_category_id' => 6,
                'image' => 'ps5_controller.jpg',
                'is_sold' => false,
                'type' => 'New',
                'years_used' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'PS4 Slim 500GB Console',
                'description' => 'PlayStation 4 Slim console with 500GB storage',
                'price' => 299.99,
                'sub_category_id' => 1,
                'image' => 'ps4_slim.jpg',
                'is_sold' => false,
                'type' => 'Used',
                'years_used' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'PS5 Standard Edition',
                'description' => 'Next-gen PlayStation 5 console with ultra-fast SSD',
                'price' => 499.99,
                'sub_category_id' => 4,
                'image' => 'ps5_console.jpg',
                'is_sold' => false,
                'type' => 'New',
                'years_used' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'PS4 Game - The Last of Us Part II',
                'description' => 'Critically acclaimed action-adventure game',
                'price' => 39.99,
                'sub_category_id' => 2,
                'image' => 'tlou2.jpg',
                'is_sold' => false,
                'type' => 'New',
                'years_used' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'PS5 Game - Spider-Man: Miles Morales',
                'description' => 'Exciting superhero action with stunning visuals',
                'price' => 49.99,
                'sub_category_id' => 5,
                'image' => 'spiderman_miles.jpg',
                'is_sold' => false,
                'type' => 'New',
                'years_used' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'PS4 Gold Headset',
                'description' => 'Wireless headset with surround sound for PS4',
                'price' => 79.99,
                'sub_category_id' => 3,
                'image' => 'ps4_headset.jpg',
                'is_sold' => false,
                'type' => 'Used',
                'years_used' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'PS5 3D Pulse Headset',
                'description' => 'Next-gen audio with 3D sound technology',
                'price' => 99.99,
                'sub_category_id' => 6,
                'image' => 'ps5_headset.jpg',
                'is_sold' => false,
                'type' => 'New',
                'years_used' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'PS4 Vertical Stand',
                'description' => 'Securely hold your PS4 in an upright position',
                'price' => 19.99,
                'sub_category_id' => 3,
                'image' => 'ps4_stand.jpg',
                'is_sold' => false,
                'type' => 'New',
                'years_used' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'PS5 Charging Station',
                'description' => 'Charge up to two DualSense controllers at once',
                'price' => 29.99,
                'sub_category_id' =>6 ,
                'image' => 'ps5_charging.jpg',
                'is_sold' => false,
                'type' => 'New',
                'years_used' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
