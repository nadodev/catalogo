<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'nadojba@hotmail.com'],
            [
                'name' => 'Administrador',
                'password' => Hash::make('nado2536'),
            ]
        );

        $this->command->info('Usuário admin criado!');
        $this->command->info('Email: nadojba@hotmail.com');
        $this->command->info('Senha: nado2536');
    }
}
