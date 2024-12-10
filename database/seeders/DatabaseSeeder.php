<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\Laboratorio::factory(10)->create();
        \App\Models\Medicamento::factory(10)->create();
        \App\Models\Clientes::factory(10)->create();
        \App\Models\Empleados::factory(10)->create();
        \App\Models\Ventas::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
