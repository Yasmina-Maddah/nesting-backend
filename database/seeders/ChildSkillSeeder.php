<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ChildSkill;

class ChildSkillSeeder extends Seeder
{
    public function run()
    {
        ChildSkill::create(['child_id' => 1, 'skill_id' => 1, 'progress' => 50]); // John - Math
        ChildSkill::create(['child_id' => 1, 'skill_id' => 2, 'progress' => 70]); // John - Reading
        ChildSkill::create(['child_id' => 2, 'skill_id' => 3, 'progress' => 40]); // Jane - Creativity
        ChildSkill::create(['child_id' => 3, 'skill_id' => 3, 'progress' => 60]); // Jane - Creativity
    }
}
