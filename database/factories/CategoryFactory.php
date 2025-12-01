<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition(): array
    {
        $categories = [
            'Canecas Personalizadas',
            'Copos e Taças',
            'Garrafas Térmicas',
            'Squeezes',
            'Canetas e Lápis',
            'Cadernos e Blocos',
            'Mochilas e Bolsas',
            'Brindes Corporativos',
        ];

        static $index = 0;
        $name = $categories[$index % count($categories)];
        $index++;

        return [
            'name' => $name,
            'slug' => \Illuminate\Support\Str::slug($name),
            'description' => fake()->paragraph(),
            'image' => null,
            'is_active' => true,
            'order' => $index,
        ];
    }
}
