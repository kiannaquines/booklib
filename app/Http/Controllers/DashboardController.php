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
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $bookReservations = BookReservation::with('book', 'space', 'user')->orderBy('status', 'desc')->get()->map(function ($bookReservation) {
            return [
                'id' => $bookReservation->id,
                'book' => $bookReservation->book->title,
                'book_id' => $bookReservation->book_id,
                'user' => $bookReservation->user->name,
                'user_id' => $bookReservation->user_id,
                'seat' => $bookReservation->space->seat_number,
                'space_id' => $bookReservation->space->id,
                'status' => $bookReservation->status,
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

    public function getReservationCharts()
    {
        $currentYear = date('Y');

        $months = collect(range(1, 12))->mapWithKeys(fn($month) => [$month => 0]);

        $bookData = BookReservation::whereYear('created_at', $currentYear)
            ->select(DB::raw('MONTH(created_at) as month'), DB::raw('COUNT(*) as total'))
            ->groupBy('month')
            ->get()
            ->pluck('total', 'month');

        $equipmentData = EquipmentReservation::whereYear('created_at', $currentYear)
            ->select(DB::raw('MONTH(created_at) as month'), DB::raw('COUNT(*) as total'))
            ->groupBy('month')
            ->get()
            ->pluck('total', 'month');

        $chartData = $months->map(function ($_, $month) use ($bookData, $equipmentData) {
            return [
                'month' => date('F', mktime(0, 0, 0, $month, 1)),
                'book' => $bookData[$month] ?? 0,
                'equipment' => $equipmentData[$month] ?? 0,
            ];
        })->values();

        return response()->json($chartData);
    }
}
