<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Medicamento>
 */
class MedicamentoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'descripcion' => $this->faker->sentence(),
            'caducidad' => $this->faker->date(),
            'precio' => $this->faker->randomFloat(2, 1, 100),
            'laboratorio_id' => $this->faker->numberBetween(1,6),
            'image' => $this->faker->imageUrl(640, 480, 'medicine'),
        ];
    }
}