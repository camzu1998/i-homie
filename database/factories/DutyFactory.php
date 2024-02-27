<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Duty>
 */
class DutyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word,
            'description' => $this->faker->text,
            'user_id' => null,
            'room_id' => null,
            'status' => 'active',
            'frequency' => 'daily',
            'start_date' => $this->faker->date(),
            'end_date' => null,
            'last_performed' => null,
        ];
    }
}
