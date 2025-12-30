<?php

namespace Database\Seeders;

use App\Models\Group;
use App\Models\SubGroup;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $groups = Group::all();

        foreach ($groups as $group) {
            SubGroup::factory()->count(2)->create([
                'group_id' => $group->id,
            ]);
        }
    }
}
