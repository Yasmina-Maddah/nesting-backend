<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CustomizationController;
use App\Http\Controllers\MoodBoardController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AiVisualizationController;
use App\Http\Controllers\SkillController;
use App\Http\Controllers\ProgressReportController;



Route::post('/signup', [AuthController::class, 'signup']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:api')->get('/user', [AuthController::class, 'getUser']);


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('profile')->group(function () {
    Route::get('{id}', [ProfileController::class, 'showProfile']);
    Route::put('{id}', [ProfileController::class, 'updateProfile']);
    Route::post('{id}/photo', [ProfileController::class, 'uploadProfilePhoto']);
    Route::post('{id}/cover', [ProfileController::class, 'uploadCoverPhoto']);
    
    Route::prefix('customization')->group(function () {
        Route::get('{id}', [CustomizationController::class, 'getCustomization']);
        Route::put('{id}', [CustomizationController::class, 'updateCustomization']);
    });

    Route::prefix('{childProfileId}/mood-board')->group(function () {
        Route::get('/', [MoodBoardController::class, 'getMoodBoard']);
        Route::post('/', [MoodBoardController::class, 'createMoodBoard']);
        Route::delete('{id}', [MoodBoardController::class, 'deleteMoodBoard']);
    });
});

Route::middleware('auth:api')->get('/user', [AuthController::class, 'getUser']);

Route::post('/child/{id}/skill/select', [SkillController::class, 'selectSkill']); // Skill selection

Route::post('/generate-story', function (Request $request) {
    $prompt = $request->input('prompt');

    if (!$prompt) {
        return response()->json(['error' => 'Prompt is required'], 400);
    }

    try {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . env('OPENAI_API_KEY'),
            'Content-Type' => 'application/json',
        ])->post('https://api.openai.com/v1/completions', [
            'model' => 'text-davinci-003',
            'prompt' => $prompt,
            'max_tokens' => 150,
            'temperature' => 0.7,
        ]);

        if ($response->failed()) {
            return response()->json(['error' => 'Failed to generate story'], 500);
        }

        return response()->json(['story' => $response->json('choices.0.text')]);
    } catch (\Exception $e) {
        return response()->json(['error' => 'An error occurred: ' . $e->getMessage()], 500);
    }
});

Route::post('/child/{id}/generate-report', [ProgressReportController::class, 'generateReport']);
Route::get('/child/{id}/report', [ProgressReportController::class, 'getReport']);