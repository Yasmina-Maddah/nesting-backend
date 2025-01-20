<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChildrenProfileController;
use App\Http\Controllers\SkillsController;
use App\Http\Controllers\AIController;



Route::post('/signup', [AuthController::class, 'signup']);
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::middleware('auth:api')->get('/user', [AuthController::class, 'getUser']);


Route::post('/child/{id}/skill/select', [SkillController::class, 'selectSkill']); // Skill selection

Route::middleware('auth:api')->group(function () {
    Route::post('/profiles', [ChildrenProfileController::class, 'createProfile']);
    Route::get('/profiles', [ChildrenProfileController::class, 'getProfiles']);
    Route::put('/profiles/{id}', [ChildrenProfileController::class, 'updateProfile']);
    Route::delete('/profiles/{id}', [ChildrenProfileController::class, 'deleteProfile']);
});

Route::middleware('auth:api')->group(function () {
    Route::get('/skills', [SkillsController::class, 'fetchSkills']); // Fetch skills
    Route::post('/assign-skill', [SkillsController::class, 'assignSkill']); // Assign skill
});


Route::middleware('auth:api')->group(function () {
    Route::get('/ai-content', [AIController::class, 'fetchAIContent']);
    Route::post('/submit-response', [AIController::class, 'submitResponse']);
    Route::get('/progress-report', [AIController::class, 'generateProgressReport']);
});


