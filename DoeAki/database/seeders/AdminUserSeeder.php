<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        // Usuário Admin
        User::create([
            'name' => 'Administrador',
            'email' => 'admin@email.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin'
        ]);

        // Alguns usuários comuns para teste
        User::create([
            'name' => 'Usuario',
            'email' => 'Usuario@email.com',
            'password' => Hash::make('usuario123'),
            'role' => 'user'
        ]);

    }
}
