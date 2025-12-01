<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user
        $this->call(UserSeeder::class);

        // Create categories
        $categories = \App\Models\Category::factory(8)->create();

        // Create tags
        $tags = \App\Models\Tag::factory(8)->create();

        // Create materials
        $materials = \App\Models\Material::factory(10)->create();

        // Create products with images and relationships
        foreach ($categories as $category) {
            $products = \App\Models\Product::factory(rand(5, 10))->create([
                'category_id' => $category->id,
            ]);

            foreach ($products as $product) {
                // Add primary image
                \App\Models\ProductImage::factory()->primary()->create([
                    'product_id' => $product->id,
                ]);

                // Add 2-4 additional images
                $additionalImagesCount = rand(2, 4);
                for ($i = 1; $i <= $additionalImagesCount; $i++) {
                    \App\Models\ProductImage::factory()->create([
                        'product_id' => $product->id,
                        'order' => $i,
                    ]);
                }

                // Attach random tags (1-3 tags per product)
                $product->tags()->attach(
                    $tags->random(rand(1, 3))->pluck('id')
                );

                // Attach random materials (1-2 materials per product)
                $product->materials()->attach(
                    $materials->random(rand(1, 2))->pluck('id')
                );
            }
        }
    }
}
