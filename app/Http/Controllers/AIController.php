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

        // Call OpenAI API
        $client = OpenAI::client(config('services.openai.api_key'));

        $response = $client->completions()->create([
            'model' => 'text-davinci-003',
            'prompt' => "Generate a story and a challenge for a child about {$skill->skill_name}. The child is named {$child->name} and is {$child->date_of_birth->diffInYears(now())} years old.",
            'max_tokens' => 500,
        ]);

        $generatedContent = $response['choices'][0]['text'];

        // Split the content into story and challenges
        // Assume story and challenges are separated by "---" in the response
        [$story, $challenges] = explode('---', $generatedContent);

        return response()->json([
            'story' => trim($story),
            'challenges' => json_decode(trim($challenges), true), // Decode JSON challenges
        ]);
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

        // Assume challenges are stored locally or retrieved dynamically
        $challenge = ChildInteraction::where('skill_id', $request->skill_id)
            ->value('challenge'); // Retrieve the relevant challenge

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
