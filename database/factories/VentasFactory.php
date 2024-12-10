<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ventas>
 */
class VentasFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'cliente_id'=>$this->faker->numberBetween(1,10),
            'medicamento_id'=>$this->faker->numberBetween(1,10),
            'cantidad' => $this->faker->numberBetween(1,100)
        ];
    }
}
