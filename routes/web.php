<?php

use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\FormBuilderController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CrudController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\TaskController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MediaController;
use App\Http\Controllers\TestController;

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
    Route::post('/tasks/sort', [TaskController::class, 'sortTasks'])->name('tasks.sort');
    Route::post('/tasks/status/sort', [TaskController::class, 'sortStatus'])->name('tasks.sort.status');
    Route::resource('/tasks', TaskController::class)->names('tasks');


    Route::group([
        'prefix' => '/media',
        'as' => 'media.',
    ], function () {
        Route::get('/', [MediaController::class, 'index'])->name('index'); // Media UI
        Route::post('/store', [MediaController::class, 'store'])->name('store'); // Upload file(s)
        Route::post('/store-folder', [MediaController::class, 'storeFolder'])->name('store.folder');
        // Route::post('/create-folder', [MediaController::class, 'createFolder'])->name('create-folder'); // Make directory
        // Route::get('/browse', [MediaController::class, 'browse'])->name('browse'); // AJAX list contents
        // Route::get('/folder-tree', [MediaController::class, 'folderTree'])->name('folder-tree'); // AJAX sidebar

        // Route::get('/download', [MediaController::class, 'downloadImage'])->name('download'); // Download file
        Route::post('/delete', [MediaController::class, 'delete'])->name('delete'); // Delete selected
    });

    Route::resource('forms', FormBuilderController::class);
    Route::get('forms/{form}/builder', [FormBuilderController::class, 'builder'])->name('forms.builder');
    Route::post('forms/{form}/builder', [FormBuilderController::class, 'saveBuilder'])->name('forms.builder.save');
    Route::resource('blogs', BlogController::class)->names('blogs');
});

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test', [TestController::class, 'index']);

require __DIR__.'/ecommerce.php';
