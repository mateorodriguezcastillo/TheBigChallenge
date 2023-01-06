<?php

namespace Database\Factories;

use App\Enums\Status;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Submission>
 */
class SubmissionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'patient_id' => UserFactory::new()->patient()->create()->id,
            'doctor_id' => UserFactory::new()->doctor()->create()->id,
            'title' => $this->faker->sentence,
            'info' => $this->faker->paragraph,
            'symptoms' => $this->faker->paragraph,
            'status' => $this->faker->randomElement(Status::keys()),
        ];
    }
}
