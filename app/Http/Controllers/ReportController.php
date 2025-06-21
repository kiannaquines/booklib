<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BookReservation;
use App\Models\EquipmentReservation;
use App\Models\SeatReservation;
use Carbon\Carbon;
use Spatie\Browsershot\Browsershot;

class ReportController extends Controller
{
    public function bookReservationView(Request $request)
    {
        $query = BookReservation::with('book', 'user')->whereBetween('created_at', [$request->fromDate, $request->toDate])->orderBy('created_at', 'asc');

        if ($request->status !== 'All') {
            $query->where('status', $request->status);
        }

        $books = $query->get()->map(function ($book) {
            return [
                'book' => $book->book->title,
                'user' => $book->user->name,
                'start_time' => $book->start_time,
                'end_time' => $book->end_time,
                'status' => $book->status,
                'created_at' => $book->created_at,
            ];
        });

        $template =  view('book-reservation', [
            'book_reservations' => $books,
            'fromDate' => Carbon::parse($request->fromDate)->timezone(config('app.timezone'))->format('F j, Y'),
            'toDate' => Carbon::parse($request->toDate)->timezone(config('app.timezone'))->format('F j, Y'),
            'status' => $request->status,
        ])->render();

        Browsershot::html($template)
            ->showBackground()
            ->format('A4')
            ->landscape()
            ->save(storage_path('app/private/book-reservation.pdf'));

        return response()->download(storage_path('app/private/book-reservation.pdf'));
    }

    public function equipmentReservationView(Request $request)
    {
        $query = EquipmentReservation::with('equipment', 'user')->whereBetween('created_at', [$request->fromDate, $request->toDate])->orderBy('created_at', 'asc');

        if ($request->status !== 'All') {
            $query->where('status', $request->status);
        }

        $equipments = $query->get()->map(function ($equipment) {
            return [
                'equipment' => $equipment->equipment->name,
                'user' => $equipment->user->name,
                'start_time' => $equipment->start_time,
                'end_time' => $equipment->end_time,
                'status' => $equipment->status,
                'created_at' => $equipment->created_at,
            ];
        });

        $template =  view('equipment-reservation', [
            'equipment_reservations' => $equipments,
            'fromDate' => Carbon::parse($request->fromDate)->timezone(config('app.timezone'))->format('F j, Y'),
            'toDate' => Carbon::parse($request->toDate)->timezone(config('app.timezone'))->format('F j, Y'),
            'status' => $request->status,
        ])->render();

        Browsershot::html($template)
            ->showBackground()
            ->format('A4')
            ->landscape()
            ->save(storage_path('app/private/equipment-reservation.pdf'));

        return response()->download(storage_path('app/private/equipment-reservation.pdf'));
    }


    public function seatReservationView(Request $request)
    {
        $query = SeatReservation::with('space', 'user')->whereBetween('created_at', [$request->fromDate, $request->toDate])->orderBy('created_at', 'asc');

        $seats = $query->get()->map(function ($equipment) {
            return [
                'space' => $equipment->space->seat_number,
                'user' => $equipment->user->name,
                'reason' => $equipment->reason,
                'created_at' => $equipment->created_at,

            ];
        });

        $template =  view('seat-reservation', [
            'seat_reservation' => $seats,
            'fromDate' => Carbon::parse($request->fromDate)->timezone(config('app.timezone'))->format('F j, Y'),
            'toDate' => Carbon::parse($request->toDate)->timezone(config('app.timezone'))->format('F j, Y'),
        ])->render();

        Browsershot::html($template)
            ->showBackground()
            ->format('A4')
            ->landscape()
            ->save(storage_path('app/private/seat-reservation.pdf'));

        return response()->download(storage_path('app/private/seat-reservation.pdf'));
    }
}
