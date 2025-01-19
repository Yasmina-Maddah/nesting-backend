<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CustomizationController;
use App\Http\Controllers\MoodBoardController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SkillController;
use App\Http\Controllers\ProgressReportController;
use App\Http\Controllers\ChildProfileController;



Route::post('/signup', [AuthController::class, 'signup']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:api')->get('/user', [AuthController::class, 'getUser']);


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::middleware('auth:sanctum')->group(function () {
    Route::get('/profiles', [ChildProfileController::class, 'index']); // Get all profiles
    Route::post('/profiles', [ChildProfileController::class, 'store']); // Create profile
    Route::get('/profiles/{id}', [ChildProfileController::class, 'show']); // Get a specific profile
    Route::put('/profiles/{id}', [ChildProfileController::class, 'update']); // Update profile
    Route::delete('/profiles/{id}', [ChildProfileController::class, 'destroy']); // Delete profile
});
 


Route::middleware('auth:api')->get('/user', [AuthController::class, 'getUser']);

Route::post('/child/{id}/skill/select', [SkillController::class, 'selectSkill']); // Skill selection

Route::post('/child/{childId}/generate-story', [AIController::class, 'generateStoryAndChallenges']);


Route::post('/child/{id}/generate-report', [ProgressReportController::class, 'generateReport']);
Route::get('/child/{id}/report', [ProgressReportController::class, 'getReport']);