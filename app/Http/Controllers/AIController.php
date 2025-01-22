<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use OpenAI;

class AIController extends Controller
{
    /**
     * Generate a visualization and story for a skill.
     */
    public function generateVisualization(Request $request)
    {
        $validated = $request->validate([
            'skill_name' => 'required|string',
            'child_name' => 'nullable|string',
        ]);

        // Retrieve OpenAI API key from configuration
        $apiKey = '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';
        if (empty($apiKey)) {
            throw new \Exception("OpenAI API key is not set or could not be retrieved.");
        }

        \Log::info('OpenAI API Key:', ['key' => $apiKey]); // Log the API key for debugging

        $client = OpenAI::client($apiKey);

        try {
            // Generate story
            $storyPrompt = "Create a fun and engaging story for a child focused on developing the skill: " . $validated['skill_name'];
            if (!empty($validated['child_name'])) {
                $storyPrompt .= " Personalize it for a child named " . $validated['child_name'] . ".";
            }

            $storyResponse = $client->chat()->create([
                'model' => 'gpt-4', // Use a chat model
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'You are a helpful assistant that creates engaging stories for children.',
                    ],
                    [
                        'role' => 'user',
                        'content' => "Create a fun and engaging story for a child focused on developing the skill: {$validated['skill_name']}." .
                            (!empty($validated['child_name']) ? " Personalize it for a child named {$validated['child_name']}." : ""),
                    ],
                ],
                'max_tokens' => 300,
            ]);
            
            $storyText = trim($storyResponse['choices'][0]['message']['content']);
            


            // Generate visualization
            $imagePrompt = "An artistic visualization of a child engaging with the skill: " . $validated['skill_name'];
            $imageResponse = $client->images()->create([
                'prompt' => $imagePrompt,
                'n' => 1,
                'size' => '1024x1024',
            ]);

            $imagePath = $imageResponse['data'][0]['url'];

            return response()->json([
                'story_text' => $storyText,
                'visualization_path' => $imagePath,
            ]);
        } catch (\Exception $e) {
            \Log::error("Error in generating visualization: " . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Generate a challenge for a skill.
     */
    public function generateChallenge(Request $request)
    {
        $validated = $request->validate([
            'skill_name' => 'required|string',
        ]);

        // Retrieve OpenAI API key
        $apiKey = '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';
        if (empty($apiKey)) {
            throw new \Exception("OpenAI API key is not set or could not be retrieved.");
        }

        $client = OpenAI::client($apiKey);

        try {
            $challengePrompt = "Create a simple challenge for a child to enhance their skill in " . $validated['skill_name'] . ".";
            $challengeResponse = $client->chat()->create([
                'model' => 'gpt-3.5-turbo', // Use a chat model
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'You are a helpful assistant that creates challenges for children.',
                    ],
                    [
                        'role' => 'user',
                        'content' => "Create a simple challenge for a child to enhance their skill in {$validated['skill_name']}.",
                    ],
                ],
                'max_tokens' => 150,
            ]);
            
            $challengeText = trim($challengeResponse['choices'][0]['message']['content']);

            return response()->json([
                'challenge' => $challengeText,
            ]);
        } catch (\Exception $e) {
            \Log::error("Error in generating challenge: " . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Save interaction for AI visualization or challenge.
     */
    public function saveInteraction(Request $request)
    {
        $validated = $request->validate([
            'child_id' => 'required|exists:children_profiles,id',
            'visualization_id' => 'nullable|exists:ai_visualizations,id',
            'response' => 'nullable|string',
            'is_correct' => 'nullable|boolean',
        ]);

        try {
            $interaction = ChildInteraction::create([
                'child_id' => $validated['child_id'],
                'visualization_id' => $validated['visualization_id'] ?? null,
                'response' => $validated['response'],
                'is_correct' => $validated['is_correct'] ?? false,
            ]);

            return response()->json([
                'message' => 'Interaction saved successfully',
                'interaction' => $interaction,
            ]);
        } catch (\Exception $e) {
            \Log::error("Error in saving interaction: " . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Fetch progress report for a child.
     */
    public function getProgress(Request $request, $child_id)
    {
        $validated = $request->validate([
            'child_id' => 'exists:children_profiles,id',
        ]);

        try {
            $progressReports = ProgressReport::where('child_id', $child_id)->get();

            if ($progressReports->isEmpty()) {
                return response()->json(['message' => 'No progress reports found.'], 404);
            }

            return response()->json([
                'progress' => $progressReports,
            ]);
        } catch (\Exception $e) {
            \Log::error("Error in fetching progress: " . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
