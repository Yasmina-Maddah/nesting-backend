<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChildrenProfileController;
use App\Http\Controllers\SkillsController;
use App\Http\Controllers\AIController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ScrapingController;
use App\Http\Controllers\GameController;


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
    Route::get('/skills', [SkillsController::class, 'fetchSkills']); // Fetch all skill categories
    Route::post('/skills/assign', [SkillsController::class, 'assignSkill']); // Assign skill to a child
    Route::get('/skills/assigned/{children_id}', [SkillsController::class, 'fetchAssignedSkill']); // Fetch assigned skill
    Route::put('/skills/update', [SkillsController::class, 'updateAssignedSkill']); // Update assigned skill
    Route::delete('/skills/remove/{children_id}', [SkillsController::class, 'removeAssignedSkill']); // Remove assigned skill
});


Route::post('/ai/visualizations', [AIController::class, 'generateVisualization']);
Route::post('/ai/challenges', [AIController::class, 'generateChallenge']);
Route::post('/ai/interactions', [AIController::class, 'saveInteraction']);
Route::get('/ai/progress/{child_id}', [AIController::class, 'getProgress']);


Route::get('/scrape-games', [ScrapingController::class, 'scrapeGames'])
    ->middleware(['jwt.auth', 'admin']);



Route::get('/games', [GameController::class, 'index']); // List all games
Route::get('/games/search', [GameController::class, 'search']); // Search games by keyword
Route::get('/games/{id}', [GameController::class, 'show']); // Get details of a specific game
    


    
    
    
    

