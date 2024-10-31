<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create();

        $categories = ['Table', 'Chair', 'Sofa', 'Bed', 'Cabinet', 'Desk', 'Shelf', 'Dresser', 'Mirror', 'Wardrobe', 'TV Stand', 'Coffee Table', 'Bookshelf', 'Nightstand', 'Dining Table', 'Stool', 'Ottoman', 'Recliner', 'Loveseat', 'Sectional Sofa'];
        foreach ($categories as $category) {
            Category::create([
                'name' => $category,
            ]);
        }

        for ($i = 1; $i <= 12; $i++) {
            Product::create([
                'image' => $i . '.png',
                'name' => 'collection ' . $i,
                'category_id' => rand(1, 12),
            ]);
        }

    }
}
