<?php

namespace Database\Seeders;

use App\Models\Group;
use App\Models\Lesson;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LessonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /* $groups = Group::with('teacher')->get(); */

        /* foreach ($groups as $group) { */
        /*     Lesson::factory()->count(5)->create([ */
        /*         'group_id' => $group->id, */
        /*         /* 'teacher_id' => $group->teacher_id, */
        /*     ]); */
    }
}
