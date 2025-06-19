<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BookReservation;
use App\Models\EquipmentReservation;
use Carbon\Carbon;
use Spatie\Browsershot\Browsershot;

class ReportController extends Controller
{
    public function bookReservationView(Request $request)
    {
        $query = BookReservation::with('book', 'user', 'space')->whereBetween('created_at', [$request->fromDate, $request->toDate]);

        if ($request->status !== 'All') {
            $query->where('status', $request->status);
        }

        $books = $query->get()->map(function ($book) {
            return [
                'book' => $book->book->title,
                'user' => $book->user->name,
                'study_space' => $book->space->seat_number,
                'start_time' => $book->start_time,
                'end_time' => $book->end_time,
                'status' => $book->status,
                'created_at' => $book->created_at,
            ];
        });

        $template =  view('book-reservation', [
            'book_reservations' => $books,
            'fromDate' => Carbon::parse($request->fromDate)->format('F j, Y'),
            'toDate' => Carbon::parse($request->toDate)->format('F j, Y'),
            'status' => $request->status,
        ])->render();

        Browsershot::html($template)
            ->showBackground()
            ->format('A4')
            ->landscape()
            ->save('book-reservation.pdf');

        return response()->download('book-reservation.pdf');
    }

    public function equipmentReservationView(Request $request)
    {
        $query = EquipmentReservation::with('equipment', 'user', 'studySpace')->whereBetween('created_at', [$request->fromDate, $request->toDate]);

        if ($request->status !== 'All') {
            $query->where('status', $request->status);
        }

        $equipments = $query->get()->map(function ($equipment) {
            return [
                'equipment' => $equipment->equipment->name,
                'user' => $equipment->user->name,
                'study_space' => $equipment->studySpace->seat_number,
                'start_time' => $equipment->start_time,
                'end_time' => $equipment->end_time,
                'status' => $equipment->status,
                'created_at' => $equipment->created_at,
            ];
        });

        $template =  view('equipment-reservation', [
            'equipment_reservations' => $equipments,
            'fromDate' => Carbon::parse($request->fromDate)->format('F j, Y'),
            'toDate' => Carbon::parse($request->toDate)->format('F j, Y'),
            'status' => $request->status,
        ])->render();

        Browsershot::html($template)
            ->showBackground()
            ->format('A4')
            ->landscape()
            ->save('equipment-reservation.pdf');

        return response()->download('equipment-reservation.pdf');
    }
}
