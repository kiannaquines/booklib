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
use App\Http\Controllers\SeatReservationController;
use App\Http\Controllers\StudentController;

Route::middleware(['auth', 'verified', 'role:admin'])->group(function () {
    // Dashboard Routes
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Index Routes
    Route::get('books', [BookController::class, 'index'])->name('books.index');
    Route::get('book-reservations', [BookReservationController::class, 'index'])->name('book-reservations.index');
    Route::get('users', [UserController::class, 'index'])->name('users.index');
    Route::get('study-spaces', [StudySpaceController::class, 'index'])->name('study-spaces.index');
    Route::get('equipments', [EquipmentController::class, 'index'])->name('equipments.index');
    Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('equipment-reservations', [EquipmentReservationController::class, 'index'])->name('equipment-reservations.index');


    // Create Routes
    Route::get('books/create', [BookController::class, 'create'])->name('books.create');
    Route::get('equipments/create', [EquipmentController::class, 'create'])->name('equipments.create');
    Route::get('study-spaces/create', [StudySpaceController::class, 'create'])->name('study-spaces.create');
    Route::get('equipment-reservations/create', [EquipmentReservationController::class, 'create'])->name('equipment-reservations.create');
    Route::get('book-reservations/create', [BookReservationController::class, 'create'])->name('book-reservations.create');
    Route::get('users/create', [UserController::class, 'create'])->name('users.create');


    // Store Routes
    Route::post('books', [BookController::class, 'store'])->name('books.store');
    Route::post('equipments', [EquipmentController::class, 'store'])->name('equipments.store');
    Route::post('study-spaces', [StudySpaceController::class, 'store'])->name('study-spaces.store');
    Route::post('users', [UserController::class, 'store'])->name('users.store');
    Route::post('book-reservations', [BookReservationController::class, 'store'])->name('book-reservations.store');
    Route::post('equipment-reservations', [EquipmentReservationController::class, 'store'])->name('equipment-reservations.store');

    // Seat Reservation Routes
    Route::get('seat-reservations', [SeatReservationController::class, 'index'])->name('seat-reservations.index');
    Route::get('seat-reservations/create', [SeatReservationController::class, 'create'])->name('seat-reservations.create');
    Route::post('seat-reservations', [SeatReservationController::class, 'store'])->name('seat-reservations.store');
    Route::get('seat-reservations/{id}', [SeatReservationController::class, 'edit'])->name('seat-reservations.edit');
    Route::put('seat-reservations/{id}', [SeatReservationController::class, 'update'])->name('seat-reservations.update');
    Route::delete('seat-reservations/{id}', [SeatReservationController::class, 'destroy'])->name('seat-reservations.destroy');

    // Edit Routes
    Route::get('books/{id}', [BookController::class, 'edit'])->name('books.edit');
    Route::get('equipments/{id}', [EquipmentController::class, 'edit'])->name('equipments.edit');
    Route::get('study-spaces/{id}', [StudySpaceController::class, 'edit'])->name('study-spaces.edit');
    Route::get('equipment-reservations/{id}', [EquipmentReservationController::class, 'edit'])->name('equipment-reservations.edit');
    Route::get('book-reservations/{id}', [BookReservationController::class, 'edit'])->name('book-reservations.edit');
    Route::get('users/{id}', [UserController::class, 'edit'])->name('users.edit');

    // Update Routes
    Route::put('books/{id}', [BookController::class, 'update'])->name('books.update');
    Route::put('equipments/{id}', [EquipmentController::class, 'update'])->name('equipments.update');
    Route::put('study-spaces/{id}', [StudySpaceController::class, 'update'])->name('study-spaces.update');
    Route::put('users/{id}', [UserController::class, 'update'])->name('users.update');
    Route::put('book-reservations/{id}', [BookReservationController::class, 'update'])->name('book-reservations.update');
    Route::put('equipment-reservations/{id}', [EquipmentReservationController::class, 'update'])->name('equipment-reservations.update');

    // Delete Routes
    Route::delete('books/{id}', [BookController::class, 'destroy'])->name('books.destroy');
    Route::delete('equipments/{id}', [EquipmentController::class, 'destroy'])->name('equipments.destroy');
    Route::delete('study-spaces/{id}', [StudySpaceController::class, 'destroy'])->name('study-spaces.destroy');
    Route::delete('users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::delete('book-reservations/{id}', [BookReservationController::class, 'destroy'])->name('book-reservations.destroy');
    Route::delete('equipment-reservations/{id}', [EquipmentReservationController::class, 'destroy'])->name('equipment-reservations.destroy');


    // API Routes
    Route::get('reservation-charts', [DashboardController::class, 'getReservationCharts'])->name('reservation-charts');

    // Report Routes
    Route::get('book-reservation', [ReportController::class, 'bookReservationView'])->name('book-reservation.view');
    Route::get('equipment-reservation', [ReportController::class, 'equipmentReservationView'])->name('equipment-reservation.view');
});

Route::middleware(['auth', 'verified'])->group(function () {

    // Student Dashboard Routes
    Route::get('student/my-book-reservation', [StudentController::class, 'myBookReservation'])->name('student.myBookReservation');
    Route::get('student/my-equipment-reservation', [StudentController::class, 'myEquipmentReservation'])->name('student.myEquipmentReservation');

    // Student Reservation Form
    Route::get('student/book-equipment', [StudentController::class, 'bookEquipment'])->name('student.bookEquipment');
    Route::get('student/equipment-reservation', [StudentController::class, 'equipmentReservation'])->name('student.equipmentReservation');

    // Student Reservation Save Data
    Route::post('student/book-equipment', [StudentController::class, 'bookEquipmentCreate'])->name('student.bookEquipmentCreate');
    Route::post('student/equipment-reservation', [StudentController::class, 'bookBookCreate'])->name('student.bookBookCreate');
});

require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
