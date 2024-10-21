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

Route::middleware(['web'])->group(function () {
    Route::post('/register', [UserController::class, 'register']);
    Route::post('/login', [UserController::class, 'login']);
    Route::post('/logout', [UserController::class, 'logout']);
    Route::get('/user', [UserController::class, 'getUser'])->middleware('auth');
    Route::post('/update', [UserController::class, 'update']);
    Route::post('/delete-account', [UserController::class, 'deleteAccount']);

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

    Route::post('/specialities', [SpecialitiesController::class, 'store']);
    Route::get('/specialities/{categoryId}', [SpecialitiesController::class, 'getByCategory']);

    Route::get('/vacancies/{id}', [VacanciesController::class, 'show']);
    Route::post('/vacancies', [VacanciesController::class, 'store']);
    Route::get('/vacancies', [VacanciesController::class, 'index']);
});
