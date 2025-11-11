<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\SeatReservation;
use App\Models\User;
use App\Models\StudySpace;

class SeatReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $reservations = SeatReservation::with(['space', 'user'])->get()->map(function ($reservation) {
            return [
                'id' => $reservation->id,
                'seat' => $reservation->space->seat_number,
                'user' => $reservation->user->name,
                'start_time' => $reservation->start_time ? $reservation->start_time->format('d/m/Y h:i:s A') : 'N/A',
                'end_time' => $reservation->end_time ? $reservation->end_time->format('d/m/Y h:i:s A') : 'N/A',
                'created_at' => $reservation->created_at->format('d/m/Y h:i:s A'),
                'updated_at' => $reservation->updated_at->format('d/m/Y h:i:s A'),
            ];
        });

        return Inertia::render('modules/seat-reservation', [
            'seatReservations' => $reservations,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::get()->map(function ($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
            ];
        });

        $spaces = StudySpace::get()->map(function ($space) {
            return [
                'id' => $space->id,
                'status' => $space->status,
                'seat' => $space->seat_number
            ];
        });
        return Inertia::render('modules/create/create-seat-reservation', [
            'users' => $users,
            'spaces' => $spaces,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'seat' => 'required|exists:study_space,id',
            'user_id' => 'required|exists:users,id',
            'reason' => 'nullable|string|max:255'
        ]);

        $space = StudySpace::findOrFail($request->seat);

        if ($space->status !== 'Available') {
            return back()->withErrors(['seat' => 'This space is not available for reservation']);
        }

        $startTime = now();
        $endTime = now()->addHours(2); // 2-hour maximum stay

        SeatReservation::create([
            'reserved_seat' => $request->seat,
            'user_id' => $request->user_id,
            'reason' => $request->reason,
            'start_time' => $startTime,
            'end_time' => $endTime,
        ]);

        StudySpace::findOrFail($request->seat)->update(['status' => 'In Use']);

        return redirect()->route('seat-reservations.index')->with('success', 'Seat reservation created successfully for 2 hours');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $reservation = SeatReservation::with(['space', 'user'])
            ->where('id', $id)
            ->first();

        $reservation = [
            'id' => $reservation->id,
            'seat' => $reservation->space->id,
            'user_id' => $reservation->user->id,
            'reason' => $reservation->reason,
        ];

        $spaces = StudySpace::get()->map(function ($space) {
            return [
                'id' => $space->id,
                'status' => $space->status,
                'seat' => $space->seat_number
            ];
        });

        $users = User::get()->map(function ($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
            ];
        });

        return Inertia::render('modules/update/update-seat-reservation', [
            'reservation' => $reservation,
            'users' => $users,
            'spaces' => $spaces,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'seat' => 'required|exists:study_space,id',
            'user_id' => 'required|exists:users,id',
            'reason' => 'nullable|string|max:255'
        ]);
        $reservation = SeatReservation::findOrFail($id);
        $space = StudySpace::findOrFail($request->seat);

        if ($reservation->reserved_seat != $request->seat) {
            return back()->withErrors(['seat' => 'You cannot change the seat of an existing reservation. Please create a new reservation for a different seat.']);
        }

        if ($space->status !== 'Available' && $reservation->reserved_seat != $request->seat) {
            return back()->withErrors(['seat' => 'This space is not available for reservation']);
        }

        // Recalculate time if updating
        $startTime = $reservation->start_time ?? now();
        $endTime = $startTime->copy()->addHours(2);

        $reservation->update([
            'reserved_seat' => $request->seat,
            'user_id' => $request->user_id,
            'reason' => $request->reason,
            'start_time' => $startTime,
            'end_time' => $endTime,
        ]);

        $space->update(['status' => 'In Use']);

        if ($reservation->reserved_seat != $request->seat) {
            StudySpace::where('id', $reservation->reserved_seat)->update(['status' => 'Available']);
        }

        return redirect()->route('seat-reservations.index')->with('success', 'Seat reservation updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        $reservation = SeatReservation::findOrFail($id);

        $reservation->delete();

        if ($request->user()->hasRole('admin')) {
            return redirect()->route('seat-reservations.index')->with('success', 'You have successfully removed the seat reservation.');
        } else {
            return redirect()->route('student.mySeatReservation')->with('success', 'You have successfully removed the seat reservation.');
        }
    }
}
