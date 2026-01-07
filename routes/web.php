<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LinkController;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('/', 'index');
    Route::view('/index', 'index')->name('index');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/links', [LinkController::class, 'index'])->name('links.create');
Route::post('/links', [LinkController::class, 'store'])->name('links.store');
Route::post('/links', [LinkController::class, 'edit'])->name('links.edit');
Route::delete('/links/{id}', [LinkController::class, 'delete'])->name('links.delete');

require __DIR__.'/auth.php';
