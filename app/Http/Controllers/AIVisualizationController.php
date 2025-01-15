<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AiVisualization;

class AiVisualizationController extends Controller
{
    // Store a new AI Visualization Request
    public function createVisualization(Request $request)
    {
        $validatedData = $request->validate([
            'parent_id' => 'required|exists:users,id',
            'skill' => 'required|string|max:255',
            'theme' => 'required|string|max:255',
            'prompt' => 'required|string',
        ]);

        // Store the request data
        $visualization = AiVisualization::create($validatedData);

        // Call an AI service to generate the story (replace with real AI logic)
        $generatedStory = $this->generateStory($validatedData['prompt'], $validatedData['skill'], $validatedData['theme']);
        $visualization->update(['generated_story' => $generatedStory]);

        return response()->json(['message' => 'Visualization created successfully', 'story' => $generatedStory]);
    }

    // Simulated AI Story Generation (replace with real AI API integration)
    private function generateStory($prompt, $skill, $theme)
    {
        return "This is a simulated story about $skill and $theme based on the prompt: $prompt";
    }

    // Get all visualizations for a parent
    public function getVisualizations($parentId)
    {
        $visualizations = AiVisualization::where('parent_id', $parentId)->get();
        return response()->json($visualizations);
    }
}
