<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\OpportunityController as AdminOpportunityController;
use App\Http\Controllers\Organizer\OpportunityController as OrganizerOpportunityController;
use App\Http\Controllers\Volunteer\OpportunityController as VolunteerOpportunityController;
use App\Http\Controllers\Admin\ApplicationController as AdminApplicationController;
use App\Http\Controllers\Organizer\ApplicationController as OrganizerApplicationController;
use App\Http\Controllers\Volunteer\ApplicationController as VolunteerApplicationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);
});


Route::middleware(['auth:sanctum', 'role:organizer'])->prefix('organizer')->group(function () {
    Route::prefix('opportunities')->group(function () {
        Route::get('/', [OrganizerOpportunityController::class, 'index']);
        Route::post('/', [OrganizerOpportunityController::class, 'store']);
        Route::get('/{opportunity}', [OrganizerOpportunityController::class, 'show']);
        Route::put('/{opportunity}', [OrganizerOpportunityController::class, 'update']);
    });

    Route::prefix('applications')->group(function () {
        Route::get('/opportunity/{opportunity_id}', [OrganizerApplicationController::class, 'index']);
        Route::put('/{application}/status', [OrganizerApplicationController::class, 'updateStatus']);
    });
});

Route::middleware(['auth:sanctum', 'role:volunteer'])->prefix('volunteer')->group(function () {
    Route::prefix('opportunities')->group(function () {
        Route::get('/', [VolunteerOpportunityController::class, 'index']);
        Route::get('/{id}', [VolunteerOpportunityController::class, 'show']);
    });

    Route::prefix('applications')->group(function () {
        Route::post('/', [VolunteerApplicationController::class, 'store']);
        Route::get('/mine', [VolunteerApplicationController::class, 'mine']);
    });
});

Route::middleware(['auth:sanctum', 'role:admin'])->prefix('admin')->group(function () {
    Route::prefix('opportunities')->group(function () {
        Route::get('/', [AdminOpportunityController::class, 'index']);
        Route::put('/{id}/status', [AdminOpportunityController::class, 'updateStatus']);
    });

    Route::prefix('applications')->group(function () {
        Route::get('/', [AdminApplicationController::class, 'index']);
        Route::get('/{application}', [AdminApplicationController::class, 'show']);
    });
});
