<?php

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

use App\Http\Controllers\UserController;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\PDFExportController;
use App\Http\Controllers\VacanciesController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\SpecialitiesController;
use App\Http\Controllers\FavoritesController;
use App\Http\Controllers\VerificationController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

Route::middleware(['web'])->group(function () {

    Route::post('/register', [UserController::class, 'register']);
    Route::post('/login', [UserController::class, 'login']);
    Route::post('/logout', [UserController::class, 'logout']);
    Route::get('/user', [UserController::class, 'getUser'])->middleware('auth');
    Route::post('/update', [UserController::class, 'update']);
    Route::post('/delete-account', [UserController::class, 'deleteAccount']);

    Route::post('/vacancies', [VacanciesController::class, 'store'])->middleware('auth');
     Route::get('/favorites/{vacancyId}', [FavoritesController::class, 'isFavorited'])->middleware('auth');
    Route::post('/favorites/{vacancyId}', [FavoritesController::class, 'toggleFavorite'])->middleware('auth');
    Route::get('/get-favorites', [FavoritesController::class, 'getFavoritedVacancies'])->middleware('auth');

    Route::post('/send-verification-email', [VerificationController::class, 'sendVerificationEmail'])->middleware('auth');

    Route::get('/email/verify', function () {
        return view('auth.verify-email');
    })->middleware('auth')->name('verification.notice');
    
    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();
    
        return redirect('http://localhost:5173/')->with('verified', true);
    })->middleware(['auth', 'signed'])->name('verification.verify');
    
    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();
    
        return back()->with('message', 'Verification link sent!');
    })->middleware(['auth', 'throttle:6,1'])->name('verification.send');
    
});

Route::get('/users', [UserController::class, 'index']);
Route::delete('/users/{user}', [UserController::class, 'destroy']);
Route::patch('/users/{user}/toggle-admin', [UserController::class, 'toggleAdmin']);

// '/api/status' returns 'API is working' if GET request succeeds
Route::get('/status', [ApiController::class, 'status']);

// Returns PDF with name, surname, email, phone number of the given user id
Route::get('/export-user-pdf/{id}', [PDFExportController::class, 'exportUserPDF']);
Route::get('/export-pdf-test', [PDFExportController::class, 'status']);

Route::post('/categories', [CategoriesController::class, 'store']);
Route::get('/categories', [CategoriesController::class, 'index']);
Route::post('/categories/check', [CategoriesController::class, 'checkIfExists']);

Route::post('/specialities', [SpecialitiesController::class, 'store']);
Route::get('/specialities/{categoryId}', [SpecialitiesController::class, 'getByCategory']);
Route::post('/specialities/check', [SpecialitiesController::class, 'checkIfExists']);

Route::get('/vacancies/{id}', [VacanciesController::class, 'show']);
Route::get('/vacancies', [VacanciesController::class, 'index']);
Route::delete('/vacancies/{id}', [VacanciesController::class, 'destroy']);
Route::get('/vacancies/{id}/download-pdf', [PDFExportController::class, 'exportVacancyPDF']);
