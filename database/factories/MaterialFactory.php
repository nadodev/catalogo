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
            'Plástico',
            'Inox',
            'Alumínio',
            'Vidro',
            'Madeira',
            'Cerâmica',
            'Silicone',
            'Acrílico',
            'Papel Reciclado',
            'Couro Sintético',
        ];

        $name = fake()->unique()->randomElement($materials);

        return [
            'name' => $name,
            'slug' => \Illuminate\Support\Str::slug($name),
        ];
    }
}
