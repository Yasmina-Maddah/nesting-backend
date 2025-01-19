<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Skill; // Use the correct model name

class SkillsSeeder extends Seeder
{
    public function run()
    {
        Skill::insert([
            [
                'skill_name' => 'Puzzle and Solve',
                'description' => 'I enjoy discovering how things work and finding solutions when something doesn’t go as planned. Whether it’s fixing a broken toy, solving a tricky puzzle, or coming up with a new way to do something, I love the challenge of thinking through problems and figuring them out.',
            ],
            [
                'skill_name' => 'Wonder and Learn',
                'description' => 'I love imagining new ideas and turning them into something real. Whether it’s drawing, building, writing stories, or making up games, I enjoy expressing myself in fun and different ways. It’s exciting to see what I can create when I let my imagination lead the way.',
            ],
            [
                'skill_name' => 'Create and Explore',
                'description' => 'I’m always curious about how things work and why they happen. I love reading, asking questions, and exploring new topics. Learning new things makes me feel excited, and I enjoy sharing what I’ve learned with others too.',
            ],
            [
                'skill_name' => 'Listen and Express',
                'description' => 'I enjoy talking to people and sharing my ideas, whether it’s telling a story, asking questions, or working with friends on a project. I like listening to others, learning from them, and finding ways to work together to make things even better.',
            ],
        ]);
    }
}
