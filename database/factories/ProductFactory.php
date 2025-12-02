<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        $products = [
            'Copo Personalizado 400ml',
            'Caneca Personalizada 300ml',
            'Squeeze Personalizado 300ml',
            'Garrafa Térmica Personalizada 500ml',
            'Caneta Personalizada 150ml',
            'Brinde Personalizado 100ml',
        ];

        $hasPrice = fake()->boolean(70);
        $name = fake()->randomElement($products).' '.fake()->numberBetween(1, 100);
        $uniqueCode = fake()->unique()->numberBetween(1000, 9999);

        return [
            'category_id' => Category::factory(),
            'name' => $name,
            'slug' => \Illuminate\Support\Str::slug($name).'-'.$uniqueCode,
            'code' => 'PROD-'.$uniqueCode,
            'description' => fake()->paragraphs(3, true),
            'specifications' => 'Dimensões: '.fake()->numberBetween(10, 30).'cm x '.fake()->numberBetween(5, 15)."cm\n".
                               'Peso: '.fake()->numberBetween(100, 500)."g\n".
                               'Cores disponíveis: Branco, Preto, Azul, Vermelho',
            'price' => $hasPrice ? fake()->randomFloat(2, 15, 250) : null,
            'show_price' => $hasPrice,
            'is_active' => true,
            'is_new' => fake()->boolean(30),
            'is_popular' => fake()->boolean(20),
            'is_featured' => fake()->boolean(15),
            'meta_title' => null,
            'meta_description' => null,
            'views_count' => fake()->numberBetween(0, 1000),
        ];
    }
}
