<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\Image;
use App\Models\Setting;
use App\Models\Slider;
use App\Models\News;
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
                'size_height_cm' => '10',
                'size_width_cm' => '10',
                'size_length_cm' => '10',
                'size_height_inch' => '10',
                'size_width_inch' => '10',
                'size_length_inch' => '10',
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
            'map' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3962.3515678641356!2d108.46951157499466!3d-6.726887893269137!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e6ee124736d1771%3A0x6215ed261cd8e7d3!2sMCA%20Furniture!5e0!3m2!1sen!2sid!4v1732004127214!5m2!1sen!2sid',
        ]);

        News::create([
            'title' => 'International Furniture Expo (IFEX) 2024',
            'description' => 'International Furniture Expo (IFEX) is an International Trade Event that exhibits quality furniture & craft products by Indonesian craftsmen.',
            'image' => '1.jpeg',
            'date' => '14-17',
            'month' => 'March',
            'year' => '2024',
        ]);
        News::create([
            'title' => 'International Furniture Expo (IFEX) 2023',
            'description' => 'International Furniture Expo (IFEX) is an International Trade Event that exhibits quality furniture & craft products by Indonesian craftsmen.',
            'image' => '2.jpeg',
            'date' => '9-12',
            'month' => 'March',
            'year' => '2023',
        ]);
    }
}
