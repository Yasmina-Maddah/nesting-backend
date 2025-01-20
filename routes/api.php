<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChildrenProfileController;
use App\Http\Controllers\SkillsController;
use App\Http\Controllers\AIController;
use App\Http\Controllers\ArticleController;




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


Route::middleware('auth:api')->group(function () {
    Route::get('/ai-content', [AIController::class, 'fetchAIContent']);
    Route::post('/submit-response', [AIController::class, 'submitResponse']);
    Route::get('/progress-report', [AIController::class, 'generateProgressReport']);
});

Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index');
Route::middleware(['auth', 'is_admin'])->group(function () {
    Route::get('/articles/create', [ArticleController::class, 'create'])->name('articles.create');
    Route::post('/articles', [ArticleController::class, 'store'])->name('articles.store');
    Route::get('/articles/{id}/edit', [ArticleController::class, 'edit'])->name('articles.edit');
    Route::put('/articles/{id}', [ArticleController::class, 'update'])->name('articles.update');
    Route::delete('/articles/{id}', [ArticleController::class, 'destroy'])->name('articles.destroy');
});

