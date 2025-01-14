<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Skill;

class SkillSeeder extends Seeder
{
    public function run()
    {
        Skill::create(['skill_name' => 'Math', 'description' => 'Basic arithmetic and problem-solving skills.']);
        Skill::create(['skill_name' => 'Reading', 'description' => 'Enhancing comprehension and vocabulary.']);
        Skill::create(['skill_name' => 'Creativity', 'description' => 'Developing artistic and imaginative skills.']);
    }
}
