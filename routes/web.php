<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\SavedIdeaController;
use App\Http\Controllers\AIController;


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

// Landing page (code entry form)
Route::get('/', [DocumentController::class, 'showCodeForm'])->name('code.form');

// Submit code
Route::post('/workspace', [DocumentController::class, 'enterCode'])->name('code.enter');

// Dashboard
Route::get('/workspace/{code}', [DocumentController::class, 'dashboard'])->name('dashboard');

// Document update
Route::put('/workspace/{code}/document', [DocumentController::class, 'update'])->name('document.update');

// Delete workspace (deletes user + doc + ideas)
Route::delete('/workspace/{code}', [DocumentController::class, 'destroy'])->name('document.destroy');

// Saved Ideas
Route::get('/workspace/{code}/ideas', [SavedIdeaController::class, 'index'])->name('ideas.index');
Route::post('/workspace/{code}/ideas', [SavedIdeaController::class, 'store'])->name('ideas.store');
Route::put('/workspace/{code}/ideas/{idea}', [SavedIdeaController::class, 'update'])->name('ideas.update');
Route::delete('/workspace/{code}/ideas/{idea}', [SavedIdeaController::class, 'destroy'])->name('ideas.destroy');

// AI generate idea
Route::post('/workspace/{code}/generate-idea', [AIController::class, 'generate'])->name('ideas.generate');