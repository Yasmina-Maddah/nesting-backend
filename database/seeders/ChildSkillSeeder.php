<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ChildSkill;

class ChildSkillSeeder extends Seeder
{
    public function run()
    {
        ChildSkill::create(['child_id' => 1, 'skill_id' => 1]); 
        ChildSkill::create(['child_id' => 1, 'skill_id' => 2]); 
        ChildSkill::create(['child_id' => 2, 'skill_id' => 3]); 
        ChildSkill::create(['child_id' => 3, 'skill_id' => 3]); 
    }
}
