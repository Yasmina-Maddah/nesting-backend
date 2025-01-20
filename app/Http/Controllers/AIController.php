<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Skill;
use App\Models\ChildrenProfile;
use App\Models\ChildInteraction;
use App\Models\ProgressReport;
use OpenAI;

class AIController extends Controller
{
    /**
     * Fetch AI Content (Story, Challenges) for the selected skill
     */
    public function fetchAIContent(Request $request)
{
    // Validate request inputs
    $request->validate([
        'child_profile_id' => 'required|exists:children_profiles,id',
        'skill_id' => 'required|exists:skills,id',
    ]);

    // Fetch related data
    $skill = Skill::find($request->skill_id);
    $child = ChildrenProfile::find($request->child_profile_id);
    $childAge = $child->age;

    // OpenAI API client setup
    $client = OpenAI::client(config('services.openai.api_key'));

    try {
        // Call OpenAI API with enhanced prompt
        $response = $client->chat()->create([
            'model' => 'gpt-4',
            'messages' => [
                [
                    'role' => 'system',
                    'content' => 'You are an assistant generating child-friendly stories and challenges. Format challenges as valid JSON.',
                ],
                [
                    'role' => 'user',
                    'content' => "Generate a story and a JSON-formatted challenge for a child named {$child->name}, who is {$childAge} years old. The theme is based on the skill '{$skill->skill_name}'. Use the following format:\n\nStory: [Story text here]\n---\nChallenges: [{\"id\":1,\"description\":\"Challenge description\",\"skills_to_use\":[\"Skill 1\",\"Skill 2\"],\"completion_time\":\"Time required\"}]. Only return the JSON challenges array with valid syntax."
                ],
            ],
            'max_tokens' => 500,
        ]);
         

        // Extract the generated content
        $generatedContent = $response['choices'][0]['message']['content'] ?? '';

        // Validate the response format
        if (!$generatedContent || strpos($generatedContent, '---') === false) {
            throw new \Exception('Invalid AI response format');
        }

        // Split the content into story and challenges
        [$story, $challenges] = explode('---', $generatedContent);
        
        // Clean and decode the challenges
        $challenges = trim($challenges);
        $challenges = preg_replace('/[^\x20-\x7E]/', '', $challenges); // Remove invalid characters
        $challenges = str_replace(['“', '”', '’'], ['"', '"', "'"], $challenges); // Replace curly quotes
        $challenges = preg_replace('/,\s*}/', '}', $challenges); // Remove trailing commas
        $challenges = json_decode($challenges, true);

        // Check for JSON decoding errors
        if (json_last_error() !== JSON_ERROR_NONE) {
            Log::error('Cleaned Challenges Content: ' . $challenges);
            throw new \Exception('Invalid JSON in challenges');
        }

        // Return the parsed response
        return response()->json([
            'story' => trim($story),
            'challenges' => $challenges,
        ]);
    } catch (\Exception $e) {
        // Log the error for debugging
        return response()->json(['error' => $e->getMessage()], 500);
    }
}


    /**
     * Submit Child's Response to a Challenge
     */
    public function submitResponse(Request $request)
    {
        $request->validate([
            'child_profile_id' => 'required|exists:children_profiles,id',
            'skill_id' => 'required|exists:skills,id',
            'challenge_id' => 'required',
            'response' => 'required|string',
        ]);

        $challenge = ChildInteraction::where('skill_id', $request->skill_id)
            ->value('challenge');

        $isCorrect = $challenge[$request->challenge_id]['correct_option'] === $request->response;

        // Record the interaction
        ChildInteraction::create([
            'child_id' => $request->child_profile_id,
            'skill_id' => $request->skill_id,
            'challenge_id' => $request->challenge_id,
            'response' => $request->response,
            'is_correct' => $isCorrect,
        ]);

        return response()->json([
            'message' => 'Response submitted successfully',
            'is_correct' => $isCorrect,
        ]);
    }

    /**
     * Generate Progress Report for a Child and a Skill
     */
    public function generateProgressReport(Request $request)
    {
        $request->validate([
            'child_profile_id' => 'required|exists:children_profiles,id',
            'skill_id' => 'required|exists:skills,id',
        ]);

        $interactions = ChildInteraction::where('child_id', $request->child_profile_id)
            ->where('skill_id', $request->skill_id)
            ->get();

        $totalChallenges = $interactions->count();
        $correctAnswers = $interactions->where('is_correct', true)->count();
        $progressScore = $totalChallenges > 0 ? round(($correctAnswers / $totalChallenges) * 100) : 0;

        // Save the progress report
        ProgressReport::create([
            'child_id' => $request->child_profile_id,
            'skill_id' => $request->skill_id,
            'interaction_summary' => $interactions,
            'progress_score' => $progressScore,
        ]);

        return response()->json([
            'total_challenges' => $totalChallenges,
            'correct_answers' => $correctAnswers,
            'progress_score' => $progressScore,
        ]);
    }
}
