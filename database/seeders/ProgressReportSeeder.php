<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProgressReport;

class ProgressReportSeeder extends Seeder
{
    public function run()
    {
        ProgressReport::create([
            'child_skill_id' => 1,
            'progress_entry' => 75,
            'details' => json_encode(['Milestone' => 'Solved advanced puzzles']),
        ]);
    }
}
