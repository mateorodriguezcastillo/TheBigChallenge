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
            'symptoms' => $this->faker->sentence,
            'status' => $this->faker->randomElement(Status::keys()),
        ];
    }

    /**
     * @return \Database\Factories\SubmissionFactory
     */
    public function inProgress(): SubmissionFactory
    {
        return $this->state(fn (array $attributes) => [
            'status' => Status::IN_PROGRESS,
        ]);
    }

    /**
     * @return \Database\Factories\SubmissionFactory
     */
    public function done(): SubmissionFactory
    {
        return $this->state(fn (array $attributes) => [
            'status' => Status::DONE,
        ]);
    }

    /**
     * @return \Database\Factories\SubmissionFactory
     */
    public function pending(): SubmissionFactory
    {
        return $this->state(fn (array $attributes) => [
            'status' => Status::PENDING,
            'doctor_id' => null,
        ]);
    }
}
