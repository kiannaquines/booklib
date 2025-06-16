<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\BookController;
use App\Http\Controllers\BookReservationController;
use App\Http\Controllers\EquipmentReservationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StudySpaceController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\DashboardController;

use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('welcome');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');


    Route::get('books', [BookController::class, 'index'])->name('books');
    Route::get('book-reservation', [BookReservationController::class, 'index'])->name('book-reservation');
    Route::get('users', [UserController::class, 'index'])->name('users');
    Route::get('study-spaces', [StudySpaceController::class, 'index'])->name('study-spaces');
    Route::get('equipments', [EquipmentController::class, 'index'])->name('equipments');
    Route::get('reports', [ReportController::class, 'index'])->name('reports');
    Route::get('equipment-reservations', [EquipmentReservationController::class, 'index'])->name('equipment-reservations');


    Route::get('create/book', [BookController::class, 'create'])->name('create-book');
    Route::get('create/equipment', [EquipmentController::class, 'create'])->name('create-equipment');
    Route::get('create/study-space', [StudySpaceController::class, 'create'])->name('create-study-space');
    Route::get('create/equipment-reservation', [EquipmentReservationController::class, 'create'])->name('create-equipment-reservation');
    Route::get('create/book-reservation', [BookReservationController::class, 'create'])->name('create-book-reservation');
    Route::get('create/user', [UserController::class, 'create'])->name('create-user');



    Route::post('books', [BookController::class, 'store'])->name('books.store');
    Route::post('equipments', [EquipmentController::class, 'store'])->name('equipments.store');
    Route::post('study-spaces', [StudySpaceController::class, 'store'])->name('study-spaces.store');
    Route::post('users', [UserController::class, 'store'])->name('users.store');
    Route::post('book-reservations', [BookReservationController::class, 'store'])->name('book-reservations.store');
    Route::post('equipment-reservations', [EquipmentReservationController::class, 'store'])->name('equipment-reservations.store');
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
