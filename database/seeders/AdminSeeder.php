<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Administrador;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        Administrador::create([
            'nombre'   => 'Admin Principal',
            'email'    => 'admin@odonto.com',
            'password' => bcrypt('123456'),
        ]);

    }
}