<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AiVisualization;
use App\Models\ChildrenProfile;
use App\Models\Skill;
use OpenAI\Client;

class AiVisualizationController extends Controller
{
    private $openai;

    public function __construct()
    {
        $this->openai = new Client(['apiKey' => config('services.openai.key')]);
    }

    public function generateVisualization(Request $request, $id)
    {
        $validated = $request->validate([
            'skill_id' => 'required|exists:skills,id',
            'theme' => 'required|string|max:255',
            'prompt' => 'required|string',
        ]);

        $child = ChildrenProfile::find($id);

        if (!$child) {
            return response()->json(['error' => 'Child profile not found'], 404);
        }

        $childAge = now()->diffInYears($child->date_of_birth);

        if ($childAge < 3 || $childAge > 7) {
            return response()->json(['error' => 'Child age must be between 3 and 7 years'], 400);
        }

        try {
            $aiResponse = $this->openai->chat()->create([
                'model' => 'gpt-3.5-turbo',
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'You are a creative story generator for children aged 3-7.',
                    ],
                    [
                        'role' => 'user',
                        'content' => $validated['prompt'],
                    ],
                ],
            ]);

            $generatedStory = $aiResponse['choices'][0]['message']['content'];

            $aiVisualization = AiVisualization::create([
                'child_id' => $id,
                'skill_id' => $validated['skill_id'],
                'theme' => $validated['theme'],
                'prompt' => $validated['prompt'],
                'generated_story' => $generatedStory,
            ]);

            return response()->json([
                'message' => 'AI visualization generated',
                'aiVisualization' => $aiVisualization,
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to generate story. Please try again later.',
                'details' => $e->getMessage(),
            ], 500);
        }
    }

    public function getVisualizations($id)
    {
        $visualizations = AiVisualization::where('child_id', $id)->get();

        if ($visualizations->isEmpty()) {
            return response()->json(['message' => 'No visualizations found for this child'], 404);
        }

        return response()->json($visualizations, 200);
    }
}
