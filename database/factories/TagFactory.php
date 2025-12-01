<?php

namespace Database\Factories;

use App\Models\Tag;
use Illuminate\Database\Eloquent\Factories\Factory;

class TagFactory extends Factory
{
    protected $model = Tag::class;

    public function definition(): array
    {
        $tags = [
            'Personalizado',
            'Ecológico',
            'Premium',
            'Corporativo',
            'Promocional',
            'Sustentável',
            'Luxo',
            'Econômico',
        ];

        $name = fake()->unique()->randomElement($tags);

        return [
            'name' => $name,
            'slug' => \Illuminate\Support\Str::slug($name),
        ];
    }
}
