<?php

namespace Database\Factories;

use App\Models\Group;
use App\Models\SubGroup;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SubGroup>
 */
class SubGroupFactory extends Factory
{
    protected $model = SubGroup::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => 'Sub-group ' . fake()->randomElement(['Alpha', 'Beta', 'Gamma', 'Delta']),
            'group_id' => Group::factory(),
        ];
    }
}
