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
            ['email' => 'admin@lumez.com.br'],
            [
                'name' => 'Administrador',
                'password' => Hash::make('admin123'),
            ]
        );

        $this->command->info('Usuário admin criado!');
        $this->command->info('Email: admin@lumez.com.br');
        $this->command->info('Senha: admin123');
    }
}
