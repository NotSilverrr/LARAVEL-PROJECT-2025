<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ColumnController;
use App\Http\Controllers\KanbanController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProjectInvitationController;
use App\Http\Controllers\ProjectUserController;
use App\Http\Controllers\ProjectViewController;
use App\Http\Controllers\TaskController;
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

// Route pour accepter l'invitation
Route::get('/invitations/{token}', [ProjectInvitationController::class, 'accept'])->name('projects.invitations.accept');
Route::post('/invitations/register', [ProjectInvitationController::class, 'register'])->name('projects.invitations.register');




Route::middleware(['auth'])->group(function () {
    Route::get('projects/create', [ProjectController::class, 'create'])->name('projects.create');
    Route::post('projects', [ProjectController::class, 'store'])->name('projects.store');
    Route::get('/projects/{project}', [ProjectController::class, 'show'])->name('projects.show');
    Route::get('/projects/{project}/edit', [ProjectController::class, 'edit'])->name('projects.edit');
    Route::get('/projects/{project}/categories', [CategoryController::class, 'index'])->name('projects.categories.index');
    Route::get('/projects/{project}/users', [ProjectUserController::class, 'index'])->name('projects.users.index');
    
    Route::get('/projects/{project}/groups', [GroupController::class, 'index'])->name('projects.groups.index');
    Route::get('/projects/{project}/groups/create', [GroupController::class, 'create'])->name('projects.groups.create');
    Route::post('/projects/{project}/groups', [GroupController::class, 'store'])->name('projects.groups.store');
    Route::get('/projects/{project}/groups/{group}/edit', [GroupController::class, 'edit'])->name('projects.groups.edit');
    Route::put('/projects/{project}/groups/{group}', [GroupController::class, 'update'])->name('projects.groups.update');
    Route::delete('/projects/{project}/groups/{group}', [GroupController::class, 'destroy'])->name('projects.groups.destroy');
    
    Route::post('/projects/{project}/inviteUser', [ProjectUserController::class, 'inviteUserToProject'])->name('projects.users.invite');
    

    Route::get('/projects/{project}/view/list', [ProjectViewController::class, 'list'])->name('projects.view.list');
    Route::get('/projects/{project}/view/kanban', [ProjectViewController::class, 'kanban'])->name('projects.view.kanban');
    Route::get('/projects/{project}/view/calendar', [ProjectViewController::class, 'calendar'])->name('projects.view.calendar');

    Route::get('/projects/{project}/tasks/create', [TaskController::class, 'create'])->name('projects.tasks.create');
    Route::post('/projects/{project}/tasks', [TaskController::class, 'store'])->name('projects.tasks.store');
    Route::get('/projects/{project}/tasks/{task}/edit', [TaskController::class, 'edit'])->name('projects.tasks.edit');
    Route::patch('/projects/{project}/tasks/{task}', [TaskController::class, 'update'])->name('projects.tasks.update');
    Route::post('/projects/{project}/column', [ColumnController::class, 'store'])->name('projects.column.store');
    Route::delete('projects/{project}/column/{column}', [ColumnController::class, 'destroy'])->name('projects.columns.destroy');

});

require __DIR__.'/auth.php';
