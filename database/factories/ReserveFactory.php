<?php

namespace Database\Factories;

use App\Models\Client;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reserve>
 */
class ReserveFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $time = $this->faker->dateTimeBetween('now', '+7 days')->format('Y-m-d H:i');
        $startTtime = Carbon::createFromFormat('Y-m-d H:i', $time);
        return [
            'client_id' => Client::all()->random(),
            'start_time' => $startTtime,
            "end_time" => $startTtime->addHour()

        ];
    }
}
