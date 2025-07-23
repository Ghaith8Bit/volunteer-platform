<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\OpportunityController as AdminOpportunityController;
use App\Http\Controllers\Organizer\OpportunityController as OrganizerOpportunityController;
use App\Http\Controllers\Volunteer\OpportunityController as VolunteerOpportunityController;
use App\Http\Controllers\Admin\ApplicationController as AdminApplicationController;
use App\Http\Controllers\Organizer\ApplicationController as OrganizerApplicationController;
use App\Http\Controllers\Volunteer\ApplicationController as VolunteerApplicationController;
use App\Http\Controllers\Admin\OrganizerController as OrganizerController;
use App\Http\Controllers\Admin\VolunteerController as VolunteerController;
use App\Http\Controllers\Admin\AdminController as AdminController;
use App\Http\Controllers\Volunteer\MessageController as MessageController;
use App\Http\Controllers\Volunteer\NotificationController as NotificationController;
use App\Http\Controllers\Volunteer\ReportController as ReportController;
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

    Route::prefix('messages')->group(function () {
        Route::get('/inbox', [\App\Http\Controllers\Organizer\MessageController::class, 'inbox']);
        Route::post('/send', [\App\Http\Controllers\Organizer\MessageController::class, 'send']);
    });

    Route::prefix('notifications')->group(function () {
        Route::get('/unread', [\App\Http\Controllers\Organizer\NotificationController::class, 'unread']);
    });

    Route::post('/reports', [\App\Http\Controllers\Organizer\ReportController::class, 'store']);

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

    Route::prefix('messages')->group(function () {
        Route::get('/inbox', [MessageController::class, 'inbox']);
        Route::post('/send', [MessageController::class, 'send']);
    });

    Route::prefix('notifications')->group(function () {
        Route::get('/unread', [NotificationController::class, 'unread']);
    });

    Route::post('/reports', [ReportController::class, 'store']);

    Route::post('/reviews', [\App\Http\Controllers\Volunteer\ReviewController::class, 'store']);


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

    Route::prefix('organizers')->group(function () {
        Route::get('/', [OrganizerController::class, 'index']);
        Route::get('/{id}', [OrganizerController::class, 'show']);
        Route::post('/', [OrganizerController::class, 'store']);
        Route::delete('/{id}', [OrganizerController::class, 'destroy']);
    });

    Route::prefix('volunteers')->group(function () {
        Route::get('/', [VolunteerController::class, 'index']);
        Route::get('/{id}', [VolunteerController::class, 'show']);
        Route::post('/', [VolunteerController::class, 'store']);
        Route::delete('/{id}', [VolunteerController::class, 'destroy']);
    });

    Route::prefix('admins')->group(function () {
        Route::get('/', [AdminController::class, 'index']);
        Route::get('/{id}', [AdminController::class, 'show']);
        Route::post('/', [AdminController::class, 'store']);
    });

    Route::prefix('messages')->group(function () {
        Route::get('/inbox', [\App\Http\Controllers\Admin\MessageController::class, 'inbox']);
        Route::post('/send', [\App\Http\Controllers\Admin\MessageController::class, 'send']);
    });

    Route::prefix('reports')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\ReportController::class, 'index']);
        Route::get('/{id}', [\App\Http\Controllers\Admin\ReportController::class, 'show']);
        Route::put('/{id}', [\App\Http\Controllers\Admin\ReportController::class, 'update']);
    });


});
