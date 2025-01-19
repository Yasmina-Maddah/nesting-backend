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



Route::middleware(['auth:api'])->group(function () {
    Route::post('/child-profile', [ChildProfileController::class, 'store']); // Create child profile
    Route::get('/child-profile', [ChildProfileController::class, 'index']); // Get all child profiles
    Route::get('/child-profile/{id}', [ChildProfileController::class, 'show']); // Get single child profile
    Route::put('/child-profile/{id}', [ChildProfileController::class, 'update']); // Update child profile
    Route::delete('/child-profile/{id}', [ChildProfileController::class, 'destroy']); // Delete child profile
    Route::post('/child-profile/{id}/upload-cover-photo', [ChildProfileController::class, 'uploadCoverPhoto']); // Add/Update cover photo
    Route::post('/child-profile/{id}/upload-profile-photo', [ChildProfileController::class, 'uploadProfilePhoto']); // Add/Update profile photo
});



Route::middleware('auth:api')->get('/user', [AuthController::class, 'getUser']);

Route::post('/child/{id}/skill/select', [SkillController::class, 'selectSkill']); // Skill selection

Route::post('/child/{childId}/generate-story', [AIController::class, 'generateStoryAndChallenges']);


Route::post('/child/{id}/generate-report', [ProgressReportController::class, 'generateReport']);
Route::get('/child/{id}/report', [ProgressReportController::class, 'getReport']);