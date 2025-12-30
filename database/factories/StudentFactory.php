<?php

namespace Database\Factories;

use App\Models\Group;
use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
{
    protected $model = Student::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'age' => fake()->numberBetween(5, 18),
            'group_id' => Group::factory(),
            'sub_group_id' => null,
            'points' => fake()->numberBetween(0, 100),
            'enrollment_date' => fake()->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
