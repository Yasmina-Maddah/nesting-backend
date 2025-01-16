<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use OpenAI;
use App\Models\AiVisualization;

class AiVisualizationController extends Controller
    {
        public function generateStory(Request $request)
        {
            try {
                $request->validate([
                    'prompt' => 'required|string',
                ]);
    
                $prompt = $request->input('prompt');
                $apiKey = env('OPENAI_API_KEY');
                $client = OpenAI::client($apiKey);
    
                $response = $client->completions()->create([
                    'model' => 'gpt-4',
                    'prompt' => $prompt,
                    'max_tokens' => 500,
                    'temperature' => 0.7,
                ]);
    
                return response()->json([
                    'generatedStory' => trim($response['choices'][0]['text']),
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'error' => $e->getMessage(),
                ], 500);
            }
        }
    }