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

Route::post('/child/{id}/ai-visualization', [AiVisualizationController::class, 'generateVisualization']); // Generate visualization
Route::get('/child/{id}/ai-visualization', [AiVisualizationController::class, 'getVisualizations']); // Get previous visualizations

Route::post('/child/{id}/generate-report', [ProgressReportController::class, 'generateReport']);
Route::get('/child/{id}/report', [ProgressReportController::class, 'getReport']);