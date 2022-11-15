<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Role>
 */
class RoleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [

        ];
    }

    /**
     * @return \Database\Factories\RoleFactory
     */
    public function doctor(): RoleFactory
    {
        return $this->state(function () {
            return [
                'id' => 1,
                'name' => 'doctor',
            ];
        });
    }

    /**
     * @return \Database\Factories\RoleFactory
     */
    public function patient(): RoleFactory
    {
        return $this->state(function () {
            return [
                'id' => 2,
                'name' => 'patient',
            ];
        });
    }
}
