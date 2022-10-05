<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});



Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/task', [TaskController::class, 'index'])->name('task');
    Route::get('/users', [UserController::class, 'index'])->name('users');

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::post('/store', [TaskController::class, 'store'])->name('store');
    Route::patch('/complete/{task}', [TaskController::class, 'markAsCompleted'])->name('complete');
    Route::patch('/todo/{task}', [TaskController::class, 'markAsToDo'])->name('todo');
    Route::patch('/edit/{task}', [TaskController::class, 'editTask'])->name('edit-task');
    Route::delete('/delete/{task}', [TaskController::class, 'deleteTask'])->name('delete');
    Route::post('/add-image', [ImageController::class, 'addImage'])->name('add-image');
    Route::get('/view-image/{$task-id}', [ImageController::class, 'viewImage'])->name('view-image');
    Route::delete('/delete-image/{image}', [Imagecontroller::class, 'deleteImage'])->name('delete-image');

});

Auth::routes();


