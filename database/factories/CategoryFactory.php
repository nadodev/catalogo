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
            'Copos Personalizadas',
            'Canecas Personalizadas',
            'Garrafas Térmicas Personalizadas',
            'Squeezes Personalizados',
            'Canetas Personalizadas',
            'Brindes Personalizados',
            'Agendas Personalizadas',
            'Cadernos Personalizados',
        ];

        static $index = 0;
        $name = $categories[$index % count($categories)];
        $baseSlug = \Illuminate\Support\Str::slug($name);

        // Garantir slug único adicionando sufixo se necessário
        $slug = $baseSlug;
        $counter = 1;
        while (\App\Models\Category::where('slug', $slug)->exists()) {
            $slug = $baseSlug.'-'.$counter;
            $counter++;
        }

        $index++;

        return [
            'name' => $name,
            'slug' => $slug,
            'description' => fake()->paragraph(),
            'image' => null,
            'is_active' => true,
            'order' => $index,
        ];
    }
}
