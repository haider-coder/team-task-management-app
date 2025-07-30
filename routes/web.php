<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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



Auth::routes(['verify' => true]);


//All Normal Users Routes List

Route::middleware(['auth', 'user-access:user'])->group(function () {

    Route::get('/', [HomeController::class, 'index'])->name('home');
   Route::get('/home', [HomeController::class, 'index'])->name('home');

});


//All Admin Routes List

Route::middleware(['auth', 'user-access:admin'])->group(function () {

    Route::get('/admin/home', [HomeController::class, 'adminHome'])->name('admin.home');
    // Tasks
    Route::get('tasks', [TaskController::class, 'index'])->name('admin.tasks.index');
    Route::get('tasks/create', [TaskController::class, 'create'])->name('admin.tasks.create');
    Route::post('tasks', [TaskController::class, 'store'])->name('admin.tasks.store');
    Route::get('tasks/{task}/edit', [TaskController::class, 'edit'])->name('admin.tasks.edit');
    Route::put('tasks/{task}', [TaskController::class, 'update'])->name('admin.tasks.update');
    Route::delete('tasks/{task}', [TaskController::class, 'destroy'])->name('admin.tasks.destroy');
    // Users
    Route::get('users', [UserController::class, 'index'])->name('admin.users.index');
    Route::get('users/{user}/show-tasks', [UserController::class, 'showTasks'])->name('admin.users.show_tasks');
    Route::delete('users/{user}', [UserController::class, 'destroy'])->name('admin.users.destroy');
    //Change User Type
    Route::patch('/admin/users/{user}/update-type', [UserController::class, 'updateType'])->name('admin.users.update-type');

});


//All Manager Routes List

Route::middleware(['auth', 'user-access:manager'])->group(function () {

    Route::get('/manager/home', [HomeController::class, 'managerHome'])->name('manager.home');

});

Route::middleware(['auth'])->group(function () {

    Route::get('tasks', [TaskController::class, 'index'])->name('admin.tasks.index');
    Route::get('tasks/pending', [TaskController::class, 'pendingTasks'])->name('tasks.pending');
    Route::get('tasks/in-progress', [TaskController::class, 'inProgressTasks'])->name('tasks.inProgress');
    Route::get('tasks/completed', [TaskController::class, 'completedTasks'])->name('tasks.completed');
    //view task that is notified by mail
    Route::get('tasks/showtask/{taskId}', [NotificationController::class, 'showtask'])->name('tasks.showtask');
    //update task status
    Route::patch('/tasks/{task}/update-status', [TaskController::class,'updateStatus'])->name('tasks.update-status');


});

//for notifying user
Route::middleware(['auth', 'user-access:admin,manager'])->group(function () {
    Route::get('/notify-user/{taskId}', [NotificationController::class, 'notifyUser'])->name('notify.user');
});

