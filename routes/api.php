<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChildrenProfileController;
use App\Http\Controllers\CustomizationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SkillController;
use App\Http\Controllers\ProgressReportController;



Route::post('/signup', [AuthController::class, 'signup']);
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::middleware('auth:api')->get('/user', [AuthController::class, 'getUser']);


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::middleware('auth:api')->group(function () {
    Route::post('/profiles', [ChildrenProfileController::class, 'createProfile']);
    Route::get('/profiles', [ChildrenProfileController::class, 'getProfiles']);
    Route::put('/profiles/{id}', [ChildrenProfileController::class, 'updateProfile']);
    Route::delete('/profiles/{id}', [ChildrenProfileController::class, 'deleteProfile']);
});

Route::post('/child/{id}/skill/select', [SkillController::class, 'selectSkill']); // Skill selection



Route::post('/child/{id}/generate-report', [ProgressReportController::class, 'generateReport']);
Route::get('/child/{id}/report', [ProgressReportController::class, 'getReport']);