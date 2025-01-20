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
    $request->validate([
        'child_profile_id' => 'required|exists:children_profiles,id',
        'skill_id' => 'required|exists:skills,id',
    ]);

    $skill = Skill::find($request->skill_id);
    $child = ChildrenProfile::find($request->child_profile_id);
    $childAge = $child->age;

    $client = OpenAI::client(config('services.openai.api_key'));

    try {
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
         

        $generatedContent = $response['choices'][0]['message']['content'] ?? '';

        if (!$generatedContent || strpos($generatedContent, '---') === false) {
            throw new \Exception('Invalid AI response format');
        }

        [$story, $challenges] = explode('---', $generatedContent);
        
        $challenges = trim($challenges);
        $challenges = preg_replace('/[^\x20-\x7E]/', '', $challenges); 
        $challenges = str_replace(['“', '”', '’'], ['"', '"', "'"], $challenges); 
        $challenges = preg_replace('/,\s*}/', '}', $challenges); 
        $challenges = json_decode($challenges, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            Log::error('Cleaned Challenges Content: ' . $challenges);
            throw new \Exception('Invalid JSON in challenges');
        }

        return response()->json([
            'story' => trim($story),
            'challenges' => $challenges,
        ]);
        } catch (\Exception $e) {
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
