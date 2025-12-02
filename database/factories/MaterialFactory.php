<?php

namespace Database\Factories;

use App\Models\Material;
use Illuminate\Database\Eloquent\Factories\Factory;

class MaterialFactory extends Factory
{
    protected $model = Material::class;

    public function definition(): array
    {
        $materials = [
            'Madeira',
            'Inox',
            'Metal',
            'Alumínio',
            'Vidro',
            'Cerâmica',
            'Outros',
        ];

        $name = fake()->unique()->randomElement($materials);

        return [
            'name' => $name,
            'slug' => \Illuminate\Support\Str::slug($name),
        ];
    }
}
