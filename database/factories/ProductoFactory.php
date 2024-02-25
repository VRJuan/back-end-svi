<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Producto>
 */
class ProductoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre' => $this->faker->word,
            'descripcion' => $this->faker->paragraph,
            'categoria_id' => \App\Models\Categoria::factory(),
            'precio' => $this->faker->randomFloat(2, 1, 100),
            'cantidad' => $this->faker->numberBetween(1, 100),
        ];
    }
}
