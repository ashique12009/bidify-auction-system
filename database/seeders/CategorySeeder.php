<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Facades\Http;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'category_name' => 'Watches',
                'category_image' => 'watches.jpg'
            ],
            [
                'category_name' => 'Art',
                'category_image' => 'art.jpg'
            ],
            [
                'category_name' => 'Fashion',
                'category_image' => 'fashion.jpg'
            ],
            [
                'category_name' => 'Home',
                'category_image' => 'home.jpg'
            ],
            [
                'category_name' => 'Electronics',
                'category_image' => 'electronics.jpg'
            ],
            [
                'category_name' => 'Jewelry',
                'category_image' => 'jewelry.jpg'
            ]
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
