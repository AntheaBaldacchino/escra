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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/', [DocumentController::class, 'showCodeForm'])->name('code.form');

Route::post('/enter-code', [DocumentController::class, 'enterCode'])->name('code.enter');

Route::get('/dashboard/{code}', [DocumentController::class, 'dashboard'])->name('dashboard');

Route::put('/document/{code}', [DocumentController::class, 'update'])->name('document.update');

Route::delete('/document/{code}', [DocumentController::class, 'destroy'])->name('document.destroy');

Route::get('/{code}/ideas', [SavedIdeaController::class, 'index'])->name('ideas.index');

Route::post('/{code}/ideas', [SavedIdeaController::class, 'store'])->name('ideas.store');

Route::put('/{code}/ideas/{idea}', [SavedIdeaController::class, 'update'])->name('ideas.update');

Route::delete('/{code}/ideas/{idea}', [SavedIdeaController::class, 'destroy'])->name('ideas.destroy');

Route::post('/{code}/generate-idea', [AIController::class, 'generate'])->name('ideas.generate');