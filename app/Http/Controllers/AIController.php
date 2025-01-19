<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\ChildSkill;
use App\Models\ChildrenProfile;
use App\Models\Skill;

class AIController extends Controller
{
    private $openAiApiKey = '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';

    public function generateStoryAndChallenges(Request $request, $childId)
    {
        $validated = $request->validate([
            'skill_id' => 'required|exists:skills,id',
        ]);

        $child = ChildrenProfile::find($childId);
        if (!$child) {
            return response()->json(['error' => 'Child not found'], 404);
        }

        $skill = Skill::find($validated['skill_id']);
        if (!$skill) {
            return response()->json(['error' => 'Skill not found'], 404);
        }

        // Generate the prompt for OpenAI
        $prompt = "Create an engaging interactive story for a child named {$child->name} who is focusing on the skill '{$skill->name}'. The story should include challenges to test the child's abilities in {$skill->name}. Provide a detailed story, followed by three challenges.";

        try {
            // Call OpenAI API
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->openAiApiKey,
            ])->post('https://api.openai.com/v1/completions', [
                'model' => 'text-davinci-003',
                'prompt' => $prompt,
                'max_tokens' => 1000,
                'temperature' => 0.7,
            ]);

            $aiResponse = $response->json();

            if (isset($aiResponse['choices'][0]['text'])) {
                $storyAndChallenges = $aiResponse['choices'][0]['text'];

                return response()->json([
                    'message' => 'AI generated story and challenges successfully',
                    'story_and_challenges' => $storyAndChallenges,
                ], 200);
            } else {
                return response()->json([
                    'error' => 'Failed to generate story and challenges. Try again.',
                ], 500);
            }
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error communicating with OpenAI: ' . $e->getMessage(),
            ], 500);
        }
    }
}
