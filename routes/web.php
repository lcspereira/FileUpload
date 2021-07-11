<?php

use Illuminate\Support\Facades\Route;
use App\Models\File;
use App\Http\Controllers\FileController;
use Illuminate\Support\Facades\Auth;

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

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::middleware(['auth:sanctum', 'verified'])->get('/files', [FileController::class, 'index'])->name('files');

Route::middleware(['auth:sanctum', 'verified'])->post('/files/create', [FileController::class, 'create'])->name('files.create');

Route::middleware(['auth:sanctum', 'verified'])->post('/files/rename/{idFile}', [FileController::class, 'rename'])->name('files.rename');

Route::middleware(['auth:sanctum', 'verified'])->get('/files/delete/{idFile}', [FileController::class, 'delete'])->name('files.delete');

Route::middleware(['auth:sanctum', 'verified'])->get('/files/download/{idFile}', [FileController::class, 'download'])->name('files.download');
