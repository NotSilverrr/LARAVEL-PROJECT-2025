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
use App\Http\Controllers\ListController;
use App\Http\Controllers\LanguageController;
use Illuminate\Support\Facades\Route;

Route::middleware(['web'])->post('/language-switch', [LanguageController::class, 'switch'])->name('language.switch');

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
Route::post('/invitations/register', [ProjectInvitationController::class, 'register'])->name('projects.invitations.register');

// Route pour rattacher l'utilisateur au projet après login si invitation en session
Route::get('/invitations/post-login', [ProjectInvitationController::class, 'postLoginInvitation'])->name('projects.invitations.postlogin');

Route::get('/invitations/{token}', [ProjectInvitationController::class, 'accept'])->name('projects.invitations.accept');


Route::middleware(['auth'])->group(function () {
    Route::get('projects/create', [ProjectController::class, 'create'])->name('projects.create');
    Route::post('projects', [ProjectController::class, 'store'])->name('projects.store');
    Route::get('/projects/{project}', [ProjectController::class, 'show'])->name('projects.show');
    Route::get('/projects/{project}/edit', [ProjectController::class, 'edit'])->name('projects.edit');
    Route::put('/projects/{project}', [ProjectController::class, 'update'])->name('projects.update');
    Route::get('/projects/{project}/categories', [CategoryController::class, 'index'])->name('projects.categories.index');
    Route::get('/projects/{project}/categories/{category}/edit', [CategoryController::class, 'edit'])->name('projects.categories.edit');
    Route::patch('/projects/{project}/categories/{category}', [CategoryController::class, 'update'])->name('projects.categories.update');
    Route::delete('/projects/{project}/categories/{category}', [CategoryController::class, 'destroy'])->name('projects.categories.destroy');
    Route::post('/projects/{project}/categories', [CategoryController::class, 'store'])->name('projects.categories.store');
    Route::get('/projects/{project}/users', [ProjectUserController::class, 'index'])->name('projects.users.index');
    
    Route::get('/projects/{project}/groups', [GroupController::class, 'index'])->name('projects.groups.index');
    Route::get('/projects/{project}/groups/create', [GroupController::class, 'create'])->name('projects.groups.create');
    Route::post('/projects/{project}/groups', [GroupController::class, 'store'])->name('projects.groups.store');
    Route::get('/projects/{project}/groups/{group}/edit', [GroupController::class, 'edit'])->name('projects.groups.edit');
    Route::put('/projects/{project}/groups/{group}', [GroupController::class, 'update'])->name('projects.groups.update');
    Route::delete('/projects/{project}/groups/{group}', [GroupController::class, 'destroy'])->name('projects.groups.destroy');
    
    Route::post('/projects/{project}/inviteUser', [ProjectUserController::class, 'inviteUserToProject'])->name('projects.users.invite');

    Route::get('/projects/{project}/view/list', [ListController::class, 'list'])->name('projects.view.list');
    Route::get('/projects/{project}/view/kanban', [ProjectViewController::class, 'kanban'])->name('projects.view.kanban');
    Route::get('/projects/{project}/view/calendar', [ProjectViewController::class, 'calendar'])->name('projects.view.calendar');
    Route::get('/projects/{project}/view/week', [ProjectViewController::class, 'week'])->name('projects.view.week');
    Route::get('/projects/{project}/view/three_days', [ProjectViewController::class, 'three_days'])->name('projects.view.three_days');
    Route::get('/projects/{project}/view/day', [ProjectViewController::class, 'day'])->name('projects.view.day');

    Route::get('/projects/{project}/tasks/create', [TaskController::class, 'create'])->name('projects.tasks.create');
    Route::post('/projects/{project}/tasks', [TaskController::class, 'store'])->name('projects.tasks.store');
    Route::get('/projects/{project}/tasks/{task}/edit', [TaskController::class, 'edit'])->name('projects.tasks.edit');
    Route::patch('/projects/{project}/tasks/{task}', [TaskController::class, 'update'])->name('projects.tasks.update');
    Route::post('/projects/{project}/column', [ColumnController::class, 'store'])->name('projects.column.store');
    Route::delete('projects/{project}/column/{column}', [ColumnController::class, 'destroy'])->name('projects.columns.destroy');
    Route::patch('/projects/{project}/column/{column}', [ColumnController::class, 'update'])->name('projects.columns.update');
    Route::delete('/projects/{project}/users/{user}', [ProjectUserController::class, 'destroy'])->name('projects.users.destroy');
    
    // Routes pour l'assignation d'utilisateurs aux tâches
    Route::post('/tasks/{task}/assign-user', [TaskController::class, 'assignUser'])->name('tasks.assign-user');
    Route::delete('/tasks/{task}/unassign-user', [TaskController::class, 'unassignUser'])->name('tasks.unassign-user');
    
    // Route de test pour les emails (développement uniquement)
    Route::get('/test-email-notification', [TaskController::class, 'testEmailNotification'])->name('test.email.notification');
});

require __DIR__.'/auth.php';
