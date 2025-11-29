<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\ChangeRequest>
 */
class ChangeRequestFactory extends Factory
{
    public function definition(): array
    {
        return [
            'project_id' => Project::factory(),
            'requested_by' => User::factory()->client(),
            'description' => fake()->paragraph(),
            'status' => fake()->randomElement(['open', 'in_review', 'completed']),
        ];
    }
}
