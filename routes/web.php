<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\TaskController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

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
    Route::post('admin/invite/{id}', [AdminController::class, 'inviteUser'])->name('admin.invite');
    Route::get('admin/assign/{id}', [TaskController::class, 'assignUser'])->name('admin.assign');
});

Route::get('invite/{token}', [AdminController::class, 'invite'])->name('user.invite');
Route::post('invited/user/login/{token}', [AdminController::class, 'invitedUserLogin'])->name('user.invited.login');

require __DIR__.'/auth.php';
