<?php

use App\Http\Controllers\Admin\CrudController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\TaskController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
// use App\Http\Controllers\Admin\CrudController;

// Route::get('/', [LoginController::class, 'loginForm'])->name('login');

Route::get('register', [RegisterController::class, 'registerForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);
Route::get('login', [LoginController::class, 'loginForm'])->name('login');
Route::post('login', [LoginController::class, 'authenticate']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('/cruds', CrudController::class)->names('cruds');
    Route::get('/menus/sort', [MenuController::class, 'sort'])->name('menus.sort');
    Route::post('/menus/save', [MenuController::class, 'saveSortedMenu'])->name('menus.save');
    Route::resource('/menus', MenuController::class)->names('menus');
    Route::post('filepond/upload', [CrudController::class, 'upload'])->name('filepond.upload');
    Route::delete('filepond/revert', [CrudController::class, 'revert'])->name('filepond.revert');

    Route::get('/tasks/kanban', [TaskController::class, 'kanban'])->name('tasks.kanban');
    Route::post('/tasks/sort', [TaskController::class, 'sort'])->name('tasks.sort');
    Route::resource('/tasks', TaskController::class)->names('tasks');
});

Route::get('/', function () {
    return view('welcome');
});
