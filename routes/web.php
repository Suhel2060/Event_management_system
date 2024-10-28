<?php

use App\Http\Controllers\AllEventDetailController;
use App\Models\Attendee;
use App\Models\Category;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\AttendeeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Auth::routes();



Route::middleware(['auth'])->group(function () {
    Route::get('/',[DashboardController::class,'index'])->name('dashboard');
    Route::get('/event',[EventController::class,'index'])->name('event');
    Route::get('/category',[CategoryController::class,'index'])->name('category');
    Route::get('/attendee',[AttendeeController::class,'index'])->name('attendee');
    Route::get('/alldata',[AllEventDetailController::class,'index'])->name('alldata');
    
});

