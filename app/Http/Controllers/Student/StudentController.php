<?php

namespace App\Http\Controllers\Student;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\BookReservation;
use App\Models\User;
use App\Models\EquipmentReservation;
use App\Models\Equipment;
use App\Models\StudySpace;
use App\Models\Books;
use App\Models\SeatReservation;

use App\Http\Controllers\Controller;

class StudentController extends Controller
{
    protected function userId(): int
    {
        return request()->user()->id;
    }

    public function myBookReservation()
    {
        $myBookReservations = BookReservation::where('user_id', $this->userId())->get()->map(function ($myBookReservation) {
            return [
                'id' => $myBookReservation->id,
                'book' => $myBookReservation->book->title,
                'book_id' => $myBookReservation->book_id,
                'user' => $myBookReservation->user->name,
                'user_id' => $myBookReservation->user_id,
                'start_time' => $myBookReservation->start_time->format('d/m/Y H:i:s'),
                'end_time' => $myBookReservation->end_time->format('d/m/Y H:i:s'),
                'status' => $myBookReservation->status,
                'created_at' => $myBookReservation->created_at->format('d/m/Y H:i:s'),
                'updated_at' => $myBookReservation->updated_at->format('d/m/Y H:i:s'),
            ];
        });

        return Inertia::render('student/my-book-reservation', [
            'myBookReservations' => $myBookReservations,
        ]);
    }

    public function myEquipmentReservation()
    {
        $myEquipmentReservations = EquipmentReservation::where('user_id', $this->userId())->get()->map(function ($myEquipmentReservation) {
            return [
                'id' => $myEquipmentReservation->id,
                'equipment' => $myEquipmentReservation->equipment->name,
                'equipment_id' => $myEquipmentReservation->equipment_id,
                'user' => $myEquipmentReservation->user->name,
                'user_id' => $myEquipmentReservation->user_id,
                'start_time' => $myEquipmentReservation->start_time->format('d/m/Y H:i:s'),
                'end_time' => $myEquipmentReservation->end_time->format('d/m/Y H:i:s'),
                'status' => $myEquipmentReservation->status,
                'created_at' => $myEquipmentReservation->created_at->format('d/m/Y H:i:s'),
                'updated_at' => $myEquipmentReservation->updated_at->format('d/m/Y H:i:s'),
            ];
        });
        return Inertia::render('student/my-equipment-reservation', [
            'myEquipmentReservations' => $myEquipmentReservations,
        ]);
    }

    public function mySeatReservation()
    {
        $reservations = SeatReservation::with(['space', 'user'])->where('user_id', $this->userId())->get()->map(function ($reservation) {
            return [
                'id' => $reservation->id,
                'seat' => $reservation->space->seat_number,
                'user' => $reservation->user->name,
                'created_at' => $reservation->created_at->format('d/m/Y H:i:s'),
                'updated_at' => $reservation->updated_at->format('d/m/Y H:i:s'),
            ];
        });

        return Inertia::render('student/my-seat-reservation', [
            'mySeatReservations' => $reservations,
        ]);
    }

    public function bookReservation()
    {
        $books = Books::all()->map(function ($book) {
            return [
                'id' => $book->id,
                'title' => $book->title,
                'status' => $book->status,
                'author' => $book->author,
            ];
        });
        return Inertia::render('student/book-reservation', [
            'books' => $books,
        ]);
    }

    public function equipmentReservation()
    {
        $equipments = Equipment::all()->map(function ($equipment) {
            return [
                'id' => $equipment->id,
                'name' => $equipment->name,
                'status' => $equipment->status,
            ];
        });
        return Inertia::render('student/equipment-reservation', [
            'equipments' => $equipments,
        ]);
    }

    public function seatReservation()
    {
        $spaces = StudySpace::get()->map(function ($space) {
            return [
                'id' => $space->id,
                'status' => $space->status,
                'seat' => $space->seat_number
            ];
        });
        return Inertia::render('student/seat-reservation', [
            'spaces' => $spaces,
        ]);
    }

    public function bookReservationCreate(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
        ]);

        BookReservation::create([
            'user_id' => $this->userId(),
            'book_id' => $request->book_id,
            'start_time' => now(),
            'end_time' => now()->addDays(3),
        ]);

        Books::where('id', $request->book_id)->update(['status' => 'Unavailable']);

        return redirect()->route('student.myBookReservation')->with(['success' => 'You have successfully reserved the book.']);
    }

    public function seatReservationCreate(Request $request)
    {
        $request->validate([
            'seat' => 'required|exists:study_space,id',
            'reason' => 'nullable|string|max:255',
        ]);

        SeatReservation::create([
            'user_id' => $this->userId(),
            'reserved_seat' => $request->seat,
            'reason' => $request->reason,
        ]);

        StudySpace::where('id', $request->seat)->update(['status' => 'In Use']);

        return redirect()->route('student.mySeatReservation')->with(['success' => 'You have successfully reserved the seat.']);
    }

    public function equipmentReservationCreate(Request $request)
    {
        $request->validate([
            'equipment' => 'required|exists:equipments,id',
        ]);

        EquipmentReservation::create([
            'user_id' => $this->userId(),
            'equipment_id' => $request->equipment,
            'start_time' => now(),
            'end_time' => now()->addDays(3),
        ]);

        Equipment::where('id', $request->equipment)->update(['status' => 'In Use']);

        return redirect()->route('student.myEquipmentReservation')->with(['success' => 'You have successfully reserved the equipment.']);
    }

    public function editBookReservation(string $id)
    {
        $bookReservation = BookReservation::findOrFail($id);
        return Inertia::render('student/update/edit-book-reservation', [
            'bookReservation' => [
                'id' => $bookReservation->id,
                'book_id' => $bookReservation->book_id,
            ],
            'books' => Books::all()->map(function ($book) {
                return [
                    'id' => $book->id,
                    'title' => $book->title,
                    'status' => $book->status,
                ];
            }),
        ]);
    }

    public function editSeatReservation(string $id)
    {
        $seatReservation = SeatReservation::findOrFail($id);
        return Inertia::render('student/update/edit-seat-reservation', [
            'seatReservation' => [
                'id' => $seatReservation->id,
                'reserved_seat' => $seatReservation->reserved_seat,
                'reason' => $seatReservation->reason,
            ],
            'spaces' => StudySpace::all()->map(function ($space) {
                return [
                    'id' => $space->id,
                    'seat' => $space->seat_number,
                    'status' => $space->status,
                ];
            }),
        ]);
    }
    public function editEquipmentReservation(string $id)
    {
        $equipmentReservation = EquipmentReservation::findOrFail($id);
        return Inertia::render('student/update/edit-equipment-reservation', [
            'equipmentReservation' => [
                'id' => $equipmentReservation->id,
                'equipment_id' => $equipmentReservation->equipment_id,
            ],
            'equipments' => Equipment::all()->map(function ($equipment) {
                return [
                    'id' => $equipment->id,
                    'name' => $equipment->name,
                    'status' => $equipment->status,
                ];
            }),
        ]);
    }

    public function updateBookReservation(Request $request, string $id)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
        ]);

        $bookReservation = BookReservation::findOrFail($id);
        $bookReservation->update([
            'book_id' => $request->book_id,
        ]);

        Books::where('id', $request->book_id)->update(['status' => 'Unavailable']);

        return redirect()->route('student.myBookReservation')->with(['success' => 'You have successfully updated the book reservation.']);
    }

    public function updateSeatReservation(Request $request, string $id)
    {
        $request->validate([
            'seat' => 'required|exists:study_space,id',
            'reason' => 'nullable|string|max:255',
        ]);

        $seatReservation = SeatReservation::findOrFail($id);
        $seatReservation->update([
            'reserved_seat' => $request->seat,
            'reason' => $request->reason,
        ]);

        StudySpace::where('id', $request->seat)->update(['status' => 'In Use']);

        return redirect()->route('student.mySeatReservation')->with(['success' => 'You have successfully updated the seat reservation.']);
    }

    public function updateEquipmentReservation(Request $request, string $id)
    {
        $request->validate([
            'equipment' => 'required|exists:equipments,id',
        ]);

        $equipmentReservation = EquipmentReservation::findOrFail($id);
        $equipmentReservation->update([
            'equipment_id' => $request->equipment,
        ]);

        Equipment::where('id', $request->equipment)->update(['status' => 'In Use']);

        return redirect()->route('student.myEquipmentReservation')->with(['success' => 'You have successfully updated the equipment reservation.']);
    }
}
