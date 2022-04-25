<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Procedure>
 */
class ProcedureFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->randomElement(['Depilação', 'Massagem', 'Cilios', 'Manicure / pedicure', 'Maquiagem']),
            'cost' => $this->faker->numberBetween(999,999999)
        ];
    }
}
