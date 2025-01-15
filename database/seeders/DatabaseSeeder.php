<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            UsersSeeder::class,
            ChildrenProfilesSeeder::class,
            SkillsSeeder::class,
            ChildSkillsSeeder::class,
            MoodBoardsSeeder::class,
            AiVisualizationsSeeder::class,
            ProgressReportsSeeder::class,
            ActivitiesSeeder::class,
            InteractionLogsSeeder::class,
        ]);
    }
}
