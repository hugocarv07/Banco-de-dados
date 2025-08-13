<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User; // Certifique-se que o caminho para seu Model de Usuário está correto

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Administrador',
            'email' => 'admin@sga.com',
            'password' => Hash::make('password'), // A senha será 'password'
        ]);
    }
}