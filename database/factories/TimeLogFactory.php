<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\TimeLog>
 */
class TimeLogFactory extends Factory
{
    public function definition(): array
    {
        return [
            'project_id' => Project::factory(),
            'user_id' => User::factory()->client(),
            'date' => now()->subDays(rand(0, 10))->toDateString(),
            'hours' => fake()->randomFloat(2, 0.5, 8),
            'description' => fake()->sentence(10),
            'approved' => false,
            'approved_by' => null,
        ];
    }
}
