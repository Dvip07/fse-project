<?php

use App\Http\Controllers\RequirementsController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\EnsureTokenIsValid;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\authenticate\AuthLogin;
use App\Http\Controllers\Auth\LoginRegistrationController;
use App\Http\Controllers\Dashboard\DashboardController;

// Pages Controller
use App\Http\Controllers\ProjectsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GPTController;

date_default_timezone_set('Asia/Kolkata');
Route::get('/refresh', function () {
    Artisan::call('key:generate');
    Artisan::call('cache:clear');
    Artisan::call('route:clear');
    Artisan::call('view:clear');
    Artisan::call('config:clear');
    Artisan::call('optimize:clear');
    return 'Refresh Done';
});

// use App\Services\GPTService;

// Route::get('/test-gpt', function (GPTService $gptService) {
//     $prompt = "Explain the significance of Laravel in web development.";
//     $response = $gptService->processMessage($prompt);

//     return response()->json(['response' => $response]);
// });


Route::controller(LoginRegistrationController::class)->group(function () {
    Route::post('/authenticate', 'authenticate')->name('authenticate');
    Route::post('/store', 'store')->name('store');
    Route::post('/logout', 'logout')->name('logout');
});

Route::get('/authenticate/login', [AuthLogin::class, 'login'])->name('authenticate-login');
Route::get('/authenticate/register', [AuthLogin::class, 'register'])->name('authenticate-register');

Route::middleware([EnsureTokenIsValid::class])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard-blank');
    Route::get('/dashboard', [DashboardController::class, 'crm'])->name('dashboard-crm');

    Route::resource('/projects' , ProjectsController::class);

    Route::get('/test-gpt', [GPTController::class, 'testGPTConnection']);

    Route::resource('/users', UserController::class);

    Route::post('/analyze-text', [GPTController::class, 'analyze']);
    Route::get('/projects/{id}/details', [ProjectsController::class, 'projectDetails']);

    Route::post('/tasks/update-status/{task}', [RequirementsController::class, 'updateStatus'])->name('tasks.updateStatus');


    // Route::post('/requirements/store', [RequirementsController::class, 'store'])->name('requirements.store');
    Route::resource('/requirements', RequirementsController::class);


});
