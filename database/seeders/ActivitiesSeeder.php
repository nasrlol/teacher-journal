<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\Group;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ActivitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $groups = Group::with('teacher')->get();

        foreach ($groups as $group) {
            Activity::factory()->count(3)->create([
                'group_id' => $group->id,
                /* 'teacher_id' => $group->teacher_id, */
            ]);
        }
    }
}
