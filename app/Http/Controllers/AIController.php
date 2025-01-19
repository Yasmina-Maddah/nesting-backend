<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AiVisualization;
use App\Models\ChildrenProfile;
use App\Models\Skill;
use Illuminate\Support\Facades\Http;

class AIController extends Controller
{
    private $openAiApiKey = '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';

    public function generateStory(Request $request, $childId)
    {
        $validated = $request->validate([
            'prompt' => 'required|string|max:1000',
        ]);

        $child = ChildrenProfile::find($childId);
        if (!$child) {
            return response()->json(['error' => 'Child not found'], 404);
        }

        $childSkill = $child->skills()->first();
        if (!$childSkill) {
            return response()->json(['error' => 'Child does not have an associated skill'], 404);
        }

        $skill = Skill::find($childSkill->skill_id);
        if (!$skill) {
            return response()->json(['error' => 'Skill not found'], 404);
        }

        $prompt = $validated['prompt'];

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->openAiApiKey,
            ])->post('https://api.openai.com/v1/completions', [
                'model' => 'text-davinci-003',
                'prompt' => "Create a story for a child with the skill '{$skill->skill_name}'. Theme: {$prompt}. Include three challenges for the child to solve.",
                'max_tokens' => 1000,
                'temperature' => 0.7,
            ]);

            $aiResponse = $response->json();

            if (!isset($aiResponse['choices'][0]['text'])) {
                return response()->json(['error' => 'AI failed to generate a story.'], 500);
            }

            $generatedStory = $aiResponse['choices'][0]['text'];
            $challenges = [
                'Solve a puzzle related to the theme',
                'Draw a picture based on the story theme',
                'Act out a part of the story with friends or family',
            ];

            $aiVisualization = AiVisualization::create([
                'child_id' => $childId,
                'skill_id' => $skill->id,
                'story' => $generatedStory,
                'challenges' => $challenges,
                'progress_percentage' => 0,
            ]);

            return response()->json([
                'message' => 'Story generated successfully!',
                'ai_visualization' => $aiVisualization,
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error communicating with OpenAI.'], 500);
        }
    }
}
