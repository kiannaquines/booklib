<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BookReservationController;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('welcome');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('dashboard');
    })->name('dashboard');


    Route::get('books', [BookController::class, 'index'])->name('books');
    Route::get('book-reservation', [BookReservationController::class, 'index'])->name('book-reservation');
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
