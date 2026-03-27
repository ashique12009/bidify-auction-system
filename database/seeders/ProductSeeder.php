<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = Category::all();
        $publisher = User::where('role', 'publisher')->first();
        
        $productsByCategory = [
            'Watches' => [
                [
                    'product_name' => 'Vintage Rolex Submariner',
                    'description' => 'Classic Rolex Submariner in excellent condition, waterproof automatic movement.',
                    'product_image' => 'https://picsum.photos/seed/jewelry/400',
                    'status' => 'running',
                    'start_price' => 8500.00,
                    'current_price' => 9200.00,
                ],
                [
                    'product_name' => 'Omega Speedmaster Professional',
                    'description' => 'Moonwatch edition, manual winding chronograph, stainless steel case.',
                    'product_image' => 'https://picsum.photos/seed/jewelry/400',
                    'status' => 'pending',
                    'start_price' => 3200.00,
                    'current_price' => 3200.00,
                ]
            ],
            'Art' => [
                [
                    'product_name' => 'Abstract Oil Painting on Canvas',
                    'description' => 'Modern abstract art piece, 24x36 inches, vibrant colors, signed by artist.',
                    'product_image' => 'https://picsum.photos/seed/jewelry/400',
                    'status' => 'running',
                    'start_price' => 1200.00,
                    'current_price' => 1450.00,
                ],
                [
                    'product_name' => 'Vintage Photography Print',
                    'description' => 'Black and white landscape photography, limited edition, museum quality.',
                    'product_image' => 'https://picsum.photos/seed/jewelry/400',
                    'status' => 'ended',
                    'start_price' => 800.00,
                    'current_price' => 1200.00,
                ]
            ],
            'Fashion' => [
                [
                    'product_name' => 'Designer Leather Handbag',
                    'description' => 'Genuine leather designer handbag, brand new with tags, limited edition.',
                    'product_image' => 'https://picsum.photos/seed/jewelry/400',
                    'status' => 'running',
                    'start_price' => 450.00,
                    'current_price' => 520.00,
                ],
                [
                    'product_name' => 'Vintage Silk Scarf Collection',
                    'description' => 'Set of 3 vintage silk scarves, various patterns, excellent condition.',
                    'product_image' => 'https://picsum.photos/seed/jewelry/400',
                    'status' => 'pending',
                    'start_price' => 150.00,
                    'current_price' => 150.00,
                ]
            ],
            'Home' => [
                [
                    'product_name' => 'Antique Wooden Cabinet',
                    'description' => '19th century mahogany cabinet, original hardware, excellent condition.',
                    'product_image' => 'https://picsum.photos/seed/jewelry/400',
                    'status' => 'running',
                    'start_price' => 2200.00,
                    'current_price' => 2500.00,
                ],
                [
                    'product_name' => 'Modern Floor Lamp',
                    'description' => 'Contemporary LED floor lamp, adjustable height, energy efficient.',
                    'product_image' => 'https://picsum.photos/seed/jewelry/400',
                    'status' => 'pending',
                    'start_price' => 180.00,
                    'current_price' => 180.00,
                ]
            ],
            'Electronics' => [
                [
                    'product_name' => 'MacBook Pro 16" M2 Max',
                    'description' => 'Latest MacBook Pro with M2 Max chip, 32GB RAM, 1TB SSD, like new.',
                    'product_image' => 'https://picsum.photos/seed/jewelry/400',
                    'status' => 'running',
                    'start_price' => 2800.00,
                    'current_price' => 3100.00,
                ],
                [
                    'product_name' => 'Vintage Turntable System',
                    'description' => 'Classic vinyl record player with speakers, fully restored, excellent sound.',
                    'product_image' => 'https://picsum.photos/seed/jewelry/400',
                    'status' => 'ended',
                    'start_price' => 350.00,
                    'current_price' => 480.00,
                ]
            ],
            'Jewelry' => [
                [
                    'product_name' => 'Diamond Engagement Ring',
                    'description' => '1.5 carat diamond ring, 18k white gold, GIA certified, stunning clarity.',
                    'product_image' => 'https://picsum.photos/seed/jewelry/400',
                    'status' => 'running',
                    'start_price' => 12000.00,
                    'current_price' => 13500.00,
                ],
                [
                    'product_name' => 'Vintage Gold Pocket Watch',
                    'description' => '14k gold pocket watch from 1920s, mechanical movement, working condition.',
                    'product_image' => 'https://picsum.photos/seed/jewelry/400',
                    'status' => 'pending',
                    'start_price' => 800.00,
                    'current_price' => 800.00,
                ]
            ]
        ];

        foreach ($categories as $category) {
            $categoryName = $category->category_name;
            
            if (isset($productsByCategory[$categoryName])) {
                foreach ($productsByCategory[$categoryName] as $productData) {

                    $response = Http::timeout(10)->get($productData['product_image']);
                    $fileName = null;
                    if ($response->successful() && str_contains($response->header('Content-Type'), 'image')) {
                        $fileName = 'products/' . Str::random(10) . '.jpg';
                        Storage::disk('public')->put($fileName, $response->body());
                    }
                    
                    Product::create([
                        'category_id' => $category->id,
                        'publisher_id' => $publisher->id,
                        'product_name' => $productData['product_name'],
                        'description' => $productData['description'],
                        'product_image' => $fileName ?? $productData['product_image'],
                        'status' => $productData['status'],
                        'start_price' => $productData['start_price'],
                        'current_price' => $productData['current_price'],
                        'start_time' => $productData['status'] === 'running' ? Carbon::now()->subDays(rand(1, 3)) : null,
                        'end_time' => $productData['status'] === 'running' ? Carbon::now()->addDays(rand(2, 7)) : null,
                    ]);
                }
            }
        }
    }
}
