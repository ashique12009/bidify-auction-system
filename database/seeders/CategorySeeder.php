<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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
                'image_url' => 'https://picsum.photos/seed/watch/400'
            ],
            [
                'category_name' => 'Art',
                'image_url' => 'https://picsum.photos/seed/art/400'
            ],
            [
                'category_name' => 'Fashion',
                'image_url' => 'https://picsum.photos/seed/fashion/400'
            ],
            [
                'category_name' => 'Home',
                'image_url' => 'https://picsum.photos/seed/home/400'
            ],
            [
                'category_name' => 'Electronics',
                'image_url' => 'https://picsum.photos/seed/electronics/400'
            ],
            [
                'category_name' => 'Jewelry',
                'image_url' => 'https://picsum.photos/seed/jewelry/400'
            ]
        ];

        foreach ($categories as $item) {
            $response = Http::timeout(10)->get($item['image_url']);

            if ($response->successful() && str_contains($response->header('Content-Type'), 'image')) {

                $fileName = 'categories/' . Str::random(10) . '.jpg';

                Storage::disk('public')->put($fileName, $response->body());

                Category::create([
                    'category_name' => $item['category_name'],
                    'category_image' => $fileName,
                ]);
            }
        }
    }
}
