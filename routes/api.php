<?php

use App\Http\Controllers\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/projects', function () {
    return response()->json([
        'projects' => [
            [
                'id' => 1,
                'name' => 'Project 1',
                'description' => 'Description of project 1',
            ],
            [
                'id' => 2,
                'name' => 'Project 2',
                'description' => 'Description of project 2',
            ],
        ],
    ]);
});

Route::patch('tasks/{task}/moveColumn/{column}', [TaskController::class, 'moveColumn'])->name('tasks.moveColumn');