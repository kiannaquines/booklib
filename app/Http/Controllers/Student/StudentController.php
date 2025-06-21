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

    public function bookEquipment()
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

    public function bookEquipmentCreate(Request $request)
    {
        $currentUser = $request->user()->id;
        $request->validate([]);
        // TODO: Save the request body
    }

    public function bookBookCreate(Request $request)
    {
        $currentUser = $request->user()->id;
        $request->validate([]);
        // TODO: Save the request body
    }

    public function bookEquipmentEdit(Request $request, string $id)
    {
        $currentUser = $request->user()->id;
        $request->validate([]);

        // TODO: Edit the request body
    }

    public function bookBookEdit(Request $request, string $id)
    {
        $currentUser = $request->user()->id;
        $request->validate(rules: []);


        // TODO: Edit the request body
    }

    public function bookEquipmentUpdate(Request $request, string $id)
    {
        $request->validate(rules: []);
        $reservation = EquipmentReservation::findOrFail($id);
        // TODO: Update the request body
    }

    public function bookBookUpdate(Request $request, string $id)
    {
        $request->validate(rules: []);
        $reservation = BookReservation::findOrFail($id);
        // TODO: Update the request body
    }

    public function bookEquipmentDestroy(Request $request, string $id)
    {
        $reservation = EquipmentReservation::findOrFail($id);
        $reservation->delete();

        return redirect()->route('student.myBookReservation')->with(['success', 'You have succesffuly removed your equipment reservation.']);
    }

    public function bookBookDestroy(Request $request, string $id)
    {
        $reservation = BookReservation::findOrFail($id);
        $reservation->delete();

        return redirect()->route('student.myBookReservation')->with(['success', 'You have succesffuly removed your book reservation.']);
    }
}
