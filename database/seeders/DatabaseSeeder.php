<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\Image;
use App\Models\Setting;
use App\Models\Slider;
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
                'size_height' => '10',
                'size_width' => '10',
                'size_length' => '10',
                'material' => 'wood',
            ]);
            Image::create([
                'product_id' => $i,
                'image' => $i . '.png',
            ]);
        }

        for ($i = 1; $i <= 3; $i++) {
            Slider::create([
                'image' => $i . '.jpg',
            ]);
        }

        Setting::create([
            'title' => 'Mandiri Cipta Adikarya',
            'logo' => 'logo.png',
            'email' => 'brita@firstupconsultants.com',
            'phone' => '502-555-0152',
            'address' => 'Jl. Suryanegara Blok Sidampul RT 04 RW 01 Desa Pamijahan Kec. Plumbon Kab. Cirebon 45159 - Indonesia',
            'linkedin' => 'https://www.linkedin.com/',
            'facebook' => 'https://www.facebook.com/',
            'instagram' => 'https://www.instagram.com/',
            'twitter' => 'https://www.twitter.com/',
            'youtube' => 'https://www.youtube.com/',
            'meta_description' => 'Mandiri Cipta Adikarya is a leading company in the field of furniture manufacturing, offering a wide range of high-quality products for home and office use.',
            'meta_author' => 'CV. Mandiri Cipta Adikarya',
            'copyright' => 'Copyright © 2024 Mandiri Cipta Adikarya. All rights reserved.',
        ]);
    }
}
