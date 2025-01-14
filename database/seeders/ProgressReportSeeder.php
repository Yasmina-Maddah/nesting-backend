<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProgressReport;

class ProgressReportSeeder extends Seeder
{
    public function run()
    {
        ProgressReport::create(['child_skill_id' => 1, 'progress_entry' => 50]); // John - Math Progress
        ProgressReport::create(['child_skill_id' => 2, 'progress_entry' => 70]); // John - Reading Progress
        ProgressReport::create(['child_skill_id' => 3, 'progress_entry' => 40]); // Jane - Creativity Progress
    }
}
