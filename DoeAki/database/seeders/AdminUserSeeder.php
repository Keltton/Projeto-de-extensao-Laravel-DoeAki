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
            'email' => 'admin@doeaki.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin'
        ]);

        // Alguns usuários comuns para teste
        User::create([
            'name' => 'João Silva',
            'email' => 'joao@email.com',
            'password' => Hash::make('senha123'),
            'role' => 'user'
        ]);

        User::create([
            'name' => 'Maria Santos',
            'email' => 'maria@email.com',
            'password' => Hash::make('senha123'),
            'role' => 'user'
        ]);
    }
}