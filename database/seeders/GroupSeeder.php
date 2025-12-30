<?php

namespace Database\Seeders;

use App\Models\Group;
use App\Models\Teacher;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $teachers = Teacher::all();

        foreach ($teachers as $teacher) {
            Group::factory()->count(2)->create([
                'teacher_id' => $teacher->id,
            ]);
        }
    }
}
