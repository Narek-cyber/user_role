<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\TaskController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\TaskController as UserTaskController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::group(['middleware' => ['auth', 'role:admin']], function() {
    Route::get('admin/users', [AdminController::class, 'index'])->name('admin.users');
    Route::get('admin/tasks', [TaskController::class, 'index'])->name('admin.tasks.index');
    Route::post('admin/task/store', [TaskController::class, 'store'])->name('admin.task.store');
    Route::get('admin/task/{id}', [TaskController::class, 'edit'])->name('admin.task.edit');
    Route::put('admin/task/{id}', [TaskController::class, 'update'])->name('admin.task.update');
    Route::put('admin/task/{id}', [TaskController::class, 'delete'])->name('admin.task.destroy');
    Route::post('admin/invite/{id}', [AdminController::class, 'inviteUser'])->name('admin.invite');
    Route::get('admin/assign/{id}', [TaskController::class, 'assignUser'])->name('admin.assign');
    Route::put('admin/assign/user/{id}', [TaskController::class, 'assignTaskToUser'])->name('admin.assign.task');
    Route::get('admin/task/status/{id}', [TaskController::class, 'taskStatus'])->name('admin.task.status');
    Route::put('admin/task/status/{id}', [TaskController::class, 'taskStatusUpdate'])->name('admin.task.status.update');
});

Route::group(['middleware' => ['auth', 'role:user']], function() {
    Route::get('user/tasks', [UserTaskController::class, 'index'])->name('user.tasks.index');
    Route::get('user/task/{id}', [UserTaskController::class, 'show'])->name('user.task.show');
    Route::get('user/task/status/{id}', [UserTaskController::class, 'taskStatus'])->name('user.task.status');
    Route::put('user/task/status/{id}', [UserTaskController::class, 'taskStatusUpdate'])->name('user.task.status.update');
});

Route::get('invite/{token}', [AdminController::class, 'invite'])->name('user.invite');
Route::post('invited/user/login/{token}', [AdminController::class, 'invitedUserLogin'])->name('user.invited.login');

require __DIR__.'/auth.php';
