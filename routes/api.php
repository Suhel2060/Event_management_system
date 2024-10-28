<?php

use App\Http\Controllers\AllEventDetailController;
use App\Http\Controllers\AttendeeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\EventController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::prefix('category')->name('category.')->group(function () {
    Route::post('/store', [CategoryController::class, 'store'])->name('store');
    Route::get('/edit/{id}', [CategoryController::class, 'edit'])->name('edit');
    Route::put('/update/{id}', [CategoryController::class, 'update'])->name('update');
    Route::delete('/delete/{id}', [CategoryController::class, 'destroy'])->name('delete');
});

// Event Routes
Route::prefix('event')->name('event.')->group(function () {
    Route::post('/store', [EventController::class, 'store'])->name('store');
    Route::get('/edit/{id}', [EventController::class, 'edit'])->name('edit');
    Route::put('/update/{id}', [EventController::class, 'update'])->name('update');
    Route::delete('/delete/{id}', [EventController::class, 'destroy'])->name('delete');
});

// Attendee Routes
Route::prefix('attendee')->name('attendee.')->group(function () {
    Route::post('/store', [AttendeeController::class, 'store'])->name('store');
    Route::get('/edit/{id}', [AttendeeController::class, 'edit'])->name('edit');
    Route::put('/update/{id}', [AttendeeController::class, 'update'])->name('update');
    Route::delete('/delete/{id}', [AttendeeController::class, 'destroy'])->name('delete');
    Route::get('/search', [AttendeeController::class, 'search'])->name('search');
});



Route::get('/search',[AllEventDetailController::class,'search']);



