<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard',[ArticleController::class,"index"])->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/articles',[ArticleController::class,"Articeles"])->middleware(['auth', 'verified'])->name('articles.Articeles');
Route::get('/article/create',[ArticleController::class,"create"])->middleware(['auth', 'verified'])->name('articles.create');
Route::post('/article/store',[ArticleController::class,"store"])->middleware(['auth', 'verified'])->name('articles.store');
Route::get('/article/edit/{article:id}',[ArticleController::class,"edit"])->middleware(['auth', 'verified'])->name('articles.edit');
Route::put('/article/update/{article:id}',[ArticleController::class,"update"])->middleware(['auth', 'verified'])->name('articles.update');
Route::delete('/article/delete/{article:id}',[ArticleController::class,"destroy"])->middleware(['auth', 'verified'])->name('articles.destroy');
Route::post('/article/updateStatus/{article:id}',[ArticleController::class,"updateStatus"])->middleware(['auth', 'verified'])->name('articles.updateStatus');
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
