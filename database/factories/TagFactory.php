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
            'Promocional',
            'Corporativo',
            'Evento',
            'Aniversário',
            'Natal',
            'Ano Novo',
            'Dia dos Namorados',
            'Dia dos Pais',
            'Dia das Mães',
            'Dia dos Pais',
        ];

        $name = fake()->unique()->randomElement($tags);

        return [
            'name' => $name,
            'slug' => \Illuminate\Support\Str::slug($name),
        ];
    }
}
