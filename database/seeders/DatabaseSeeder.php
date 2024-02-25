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
        // \App\Models\Usuario::factory(15)->create();
        // \App\Models\Cargo::factory(6)->create();
        \App\Models\Producto::factory(6)->create();
        \App\Models\Categoria::factory(3)->create();
    }
}
