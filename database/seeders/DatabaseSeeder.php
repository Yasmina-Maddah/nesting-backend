<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            UserSeeder::class,
            ChildrenProfileSeeder::class,
            SkillSeeder::class,
            ChildSkillSeeder::class,
            MoodBoardSeeder::class,
            AiVisualizationSeeder::class,
            ProgressReportSeeder::class,
            ActivitiesSeeder::class,
            InteractionLogsSeeder::class,
        ]);
    }
}
