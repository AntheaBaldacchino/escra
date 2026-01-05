<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DocumentController;

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

