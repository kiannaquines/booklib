<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\BookReservation;
use Inertia\Inertia;
use App\Models\User;
use App\Models\Books;
use App\Models\Equipment;
use App\Models\StudySpace;
use App\Models\EquipmentReservation;

class DashboardController extends Controller
{
    public function index()
    {
        $bookReservations = BookReservation::with('book', 'space', 'user')->get()->map(function ($bookReservation) {
            return [
                'id' => $bookReservation->id,
                'book' => $bookReservation->book->title,
                'book_id' => $bookReservation->book_id,
                'user' => $bookReservation->user->name,
                'user_id' => $bookReservation->user_id,
                'seat_number' => $bookReservation->space->seat_number,
                'space_id' => $bookReservation->space->id,
                'start_time' => $bookReservation->start_time->format('d/m/Y H:i:s'),
                'end_time' => $bookReservation->end_time->format('d/m/Y H:i:s'),
                'created_at' => $bookReservation->created_at->format('d/m/Y H:i:s'),
                'updated_at' => $bookReservation->updated_at->format('d/m/Y H:i:s'),
            ];
        });


        $totalUsers = User::count();
        $totalBooks = Books::count();
        $totalEquipment = Equipment::count();
        $totalStudySpaces = StudySpace::count();
        $totalEquipmentReservations = EquipmentReservation::count();

        return Inertia::render('dashboard', [
            'reservations' => $bookReservations,
            'totalUsers' => $totalUsers,
            'totalBooks' => $totalBooks,
            'totalEquipment' => $totalEquipment,
            'totalStudySpaces' => $totalStudySpaces,
            'totalEquipmentReservations' => $totalEquipmentReservations,
        ]);
    }
}
