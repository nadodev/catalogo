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

        // Create categories (usando firstOrCreate para evitar duplicatas)
        $categoryNames = [
            'Copos Personalizadas',
            'Canecas Personalizadas',
            'Garrafas Térmicas Personalizadas',
            'Squeezes Personalizados',
            'Canetas Personalizadas',
            'Brindes Personalizados',
            'Agendas Personalizadas',
            'Cadernos Personalizados',
        ];

        $categories = collect();
        foreach ($categoryNames as $index => $name) {
            $categories->push(
                \App\Models\Category::firstOrCreate(
                    ['slug' => \Illuminate\Support\Str::slug($name)],
                    [
                        'name' => $name,
                        'description' => fake()->paragraph(),
                        'image' => null,
                        'is_active' => true,
                        'order' => $index + 1,
                    ]
                )
            );
        }

        // Create tags (usando firstOrCreate para evitar duplicatas)
        $tagNames = [
            'Personalizado',
            'Ecológico',
            'Premium',
            'Promocional',
            'Corporativo',
            'Evento',
            'Brinde',
            'Presente',
        ];

        $tags = collect();
        foreach ($tagNames as $name) {
            $tags->push(
                \App\Models\Tag::firstOrCreate(
                    ['slug' => \Illuminate\Support\Str::slug($name)],
                    ['name' => $name]
                )
            );
        }

        // Create materials (usando firstOrCreate para evitar duplicatas)
        $materialNames = [
            'Madeira',
            'Inox',
            'Metal',
            'Alumínio',
            'Vidro',
            'Cerâmica',
            'Plástico',
            'Bambu',
            'Silicone',
            'Tecido',
        ];

        $materials = collect();
        foreach ($materialNames as $name) {
            $materials->push(
                \App\Models\Material::firstOrCreate(
                    ['slug' => \Illuminate\Support\Str::slug($name)],
                    ['name' => $name]
                )
            );
        }

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
