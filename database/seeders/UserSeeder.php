<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $usuarios = [
            ['name' => 'Ana Organizadora',  'email' => 'ana@eventos.test',   'tipo' => 'organizador'],
            ['name' => 'Bruno Organizador', 'email' => 'bruno@eventos.test', 'tipo' => 'organizador'],
            ['name' => 'Carla Cliente',  'email' => 'carla@eventos.test', 'tipo' => 'cliente'],
            ['name' => 'Diego Cliente',  'email' => 'diego@eventos.test', 'tipo' => 'cliente'],
        ];

        foreach ($usuarios as $usuario) {
            User::create($usuario + ['password' => 'senha123']);
        }
    }
}
