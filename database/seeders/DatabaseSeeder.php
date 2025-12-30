<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create a test user
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Seed in order of dependencies
        $this->call([
            TeacherSeeder::class,
            GroupSeeder::class,
            SubGroupSeeder::class,
            StudentSeeder::class,
            LessonSeeder::class,
            ActivitiesSeeder::class,
        ]);
    }
}
