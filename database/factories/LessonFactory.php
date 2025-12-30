<?php

namespace Database\Factories;

use App\Models\Group;
use App\Models\Lesson;
use App\Models\Teacher;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Lesson>
 */
class LessonFactory extends Factory
{
    protected $model = Lesson::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'topic' => fake()->sentence(3),
            'description' => fake()->paragraph(),
            'teacher_id' => Teacher::factory(),
            'group_id' => Group::factory(),
            'scheduled_at' => fake()->dateTimeBetween('now', '+1 month'),
            'duration_minutes' => fake()->randomElement([30, 45, 60, 90]),
        ];
    }
}
