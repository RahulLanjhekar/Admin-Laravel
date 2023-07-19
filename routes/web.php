<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//Normal Users Routes List
Route::middleware(['auth', 'user-access:user'])->group(function () {
   
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('tasks/create', [HomeController::class, 'create'])->name('tasks.create');
    Route::post('tasks/store', [HomeController::class, 'store'])->name('tasks.store');
    Route::get('tasks/{id}/edit',[HomeController::class, 'edit']);
    Route::put('tasks/{id}/update',[HomeController::class, 'update']);
    Route::delete('tasks/{id}/delete',[HomeController::class, 'delete']);
    Route::get('tasks/{id}/show',[HomeController::class, 'show']);
    Route::get('tasks/search',[HomeController::class, 'search']);
});
   
//Admin Routes List
Route::middleware(['auth', 'user-access:admin'])->group(function () {
   
    Route::get('/admin/home', [AdminController::class, 'adminHome'])->name('admin.home');
});