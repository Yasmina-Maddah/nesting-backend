<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\InteractionLog;

class InteractionLogsSeeder extends Seeder
{
    public function run()
    {
        InteractionLog::create([
            'child_id' => 1,
            'activity_id' => 1,
            'interaction_time' => now(),
            'notes' => 'Child completed the puzzle within 30 minutes.',
        ]);
    }
}
