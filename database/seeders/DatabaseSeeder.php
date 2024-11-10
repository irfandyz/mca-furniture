<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\Image;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(8)->create(['role' => 'admin']);
        User::factory(2)->create(['role' => 'superadmin']);

        $categories = ['Table', 'Chair', 'Sofa', 'Bed', 'Cabinet', 'Desk', 'Shelf', 'Dresser', 'Mirror', 'Wardrobe', 'TV Stand', 'Coffee Table', 'Bookshelf', 'Nightstand', 'Dining Table', 'Stool', 'Ottoman', 'Recliner', 'Loveseat', 'Sectional Sofa'];
        foreach ($categories as $category) {
            Category::create([
                'name' => $category,
            ]);
        }

        for ($i = 1; $i <= 14; $i++) {
            Product::create([
                'name' => 'collection ' . $i,
                'category_id' => rand(1, 12),
                'code' => rand(100000, 999999),
                'color' => 'red',
                'size' => '10 x 10 x 10',
                'material' => 'wood',
            ]);
            Image::create([
                'product_id' => $i,
                'image' => $i . '.png',
            ]);
        }

    }
}
