<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AiVisualization;

class AiVisualizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AiVisualization::create([
            'child_id' => 1,
            'skill_id' => 1,
            'story' => 'Once upon a time, a brave adventurer solved the hardest puzzles to save their village.',
            'challenges' => json_encode([
                [
                    'question' => 'What is 5 + 7?',
                    'answer' => '12',
                ],
                [
                    'question' => 'Rearrange these letters to form a word: O P E H',
                    'answer' => 'HOPE',
                ],
            ]),
            'interaction_data' => json_encode([
                [
                    'challenge_id' => 1,
                    'child_answer' => '12',
                    'is_correct' => true,
                ],
                [
                    'challenge_id' => 2,
                    'child_answer' => 'HOPE',
                    'is_correct' => true,
                ],
            ]),
            'progress_percentage' => 50,
        ]);

        AiVisualization::create([
            'child_id' => 2,
            'skill_id' => 2,
            'story' => 'A young scientist learned about the stars and made a groundbreaking discovery.',
            'challenges' => json_encode([
                [
                    'question' => 'What planet is known as the Red Planet?',
                    'answer' => 'Mars',
                ],
                [
                    'question' => 'Which gas do plants use for photosynthesis?',
                    'answer' => 'Carbon Dioxide',
                ],
            ]),
            'interaction_data' => json_encode([
                [
                    'challenge_id' => 1,
                    'child_answer' => 'Mars',
                    'is_correct' => true,
                ],
                [
                    'challenge_id' => 2,
                    'child_answer' => 'Oxygen',
                    'is_correct' => false,
                ],
            ]),
            'progress_percentage' => 75,
        ]);

        AiVisualization::create([
            'child_id' => 3,
            'skill_id' => 3,
            'story' => 'An artist created beautiful paintings that inspired the whole world.',
            'challenges' => json_encode([
                [
                    'question' => 'What colors do you mix to make purple?',
                    'answer' => 'Red and Blue',
                ],
            ]),
            'interaction_data' => json_encode([
                [
                    'challenge_id' => 1,
                    'child_answer' => 'Red and Blue',
                    'is_correct' => true,
                ],
            ]),
            'progress_percentage' => 100,
        ]);
    }
}
