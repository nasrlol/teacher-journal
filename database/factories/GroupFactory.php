<?php

namespace Database\Factories;

use App\Models\Group;
use App\Models\Teacher;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Group>
 */
class GroupFactory extends Factory
{
    protected $model = Group::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->randomElement(['Class A', 'Class B', 'Class C', 'Class D']) . ' - ' . fake()->word(),
            /* 'teacher_id' => Teacher::factory(), */
        ];
    }
}
