<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Activity;

class ActivitiesSeeder extends Seeder
{
    public function run()
    {
        Activity::create([
            'child_skill_id' => 1,
            'description' => 'Solve a 50-piece jigsaw puzzle',
            'status' => 'completed',
        ]);
    }
}
