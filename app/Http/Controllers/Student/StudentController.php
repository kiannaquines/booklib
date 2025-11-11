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
use Illuminate\Support\Facades\Cache;

use App\Http\Controllers\Controller;

class StudentController extends Controller
{
    const MAX_DAILY_RESERVATIONS = 25;

    protected function userId(): int
    {
        return request()->user()->id;
    }

    protected function canMakeReservation(string $type): bool
    {
        $userId = $this->userId();
        $today = now()->toDateString();
        $cacheKey = "reservations_{$type}_{$userId}_{$today}";
        
        $count = Cache::get($cacheKey, 0);
        
        return $count < self::MAX_DAILY_RESERVATIONS;
    }

    protected function incrementReservationCount(string $type): void
    {
        $userId = $this->userId();
        $today = now()->toDateString();
        $cacheKey = "reservations_{$type}_{$userId}_{$today}";
        
        $count = Cache::get($cacheKey, 0);
        Cache::put($cacheKey, $count + 1, now()->endOfDay());
    }

    protected function getRemainingReservations(string $type): int
    {
        $userId = $this->userId();
        $today = now()->toDateString();
        $cacheKey = "reservations_{$type}_{$userId}_{$today}";
        
        $count = Cache::get($cacheKey, 0);
        
        return max(0, self::MAX_DAILY_RESERVATIONS - $count);
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
                'start_time' => $myBookReservation->start_time->format('d/m/Y h:i:s A'),
                'end_time' => $myBookReservation->end_time->format('d/m/Y h:i:s A'),
                'status' => $myBookReservation->status,
                'created_at' => $myBookReservation->created_at->format('d/m/Y h:i:s A'),
                'updated_at' => $myBookReservation->updated_at->format('d/m/Y h:i:s A'),
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
                'start_time' => $myEquipmentReservation->start_time->format('d/m/Y h:i:s A'),
                'end_time' => $myEquipmentReservation->end_time->format('d/m/Y h:i:s A'),
                'status' => $myEquipmentReservation->status,
                'created_at' => $myEquipmentReservation->created_at->format('d/m/Y h:i:s A'),
                'updated_at' => $myEquipmentReservation->updated_at->format('d/m/Y h:i:s A'),
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
                'start_time' => $reservation->start_time ? $reservation->start_time->format('d/m/Y h:i:s A') : null,
                'end_time' => $reservation->end_time ? $reservation->end_time->format('d/m/Y h:i:s A') : null,
                'duration' => '2 hours',
                'created_at' => $reservation->created_at->format('d/m/Y h:i:s A'),
                'updated_at' => $reservation->updated_at->format('d/m/Y h:i:s A'),
            ];
        });

        return Inertia::render('student/my-seat-reservation', [
            'mySeatReservations' => $reservations,
        ]);
    }

    public function bookReservation()
    {
        $books = Books::all()->map(function ($book) {
            // Reset if last reset was not today
            if ($book->last_reset_date != now()->toDateString()) {
                $book->update([
                    'reserved_today' => 0,
                    'last_reset_date' => now()->toDateString(),
                ]);
            }
            
            return [
                'id' => $book->id,
                'title' => $book->title,
                'status' => $book->status,
                'author' => $book->author,
                'image' => $book->image ? asset('storage/' . $book->image) : null,
                'description' => $book->description,
                'max_slots' => $book->max_slots,
                'reserved_today' => $book->reserved_today,
                'available_slots' => $book->max_slots - $book->reserved_today,
                'available_quantity' => $book->available_quantity,
                'total_quantity' => $book->total_quantity,
            ];
        });
        return Inertia::render('student/book-reservation', [
            'books' => $books,
            'remainingReservations' => $this->getRemainingReservations('book'),
        ]);
    }

    public function equipmentReservation()
    {
        $equipments = Equipment::all()->map(function ($equipment) {
            // Reset if last reset was not today
            if ($equipment->last_reset_date != now()->toDateString()) {
                $equipment->update([
                    'reserved_today' => 0,
                    'last_reset_date' => now()->toDateString(),
                ]);
            }
            
            return [
                'id' => $equipment->id,
                'name' => $equipment->name,
                'status' => $equipment->status,
                'image' => $equipment->image ? asset('storage/' . $equipment->image) : null,
                'description' => $equipment->description,
                'max_slots' => $equipment->max_slots,
                'reserved_today' => $equipment->reserved_today,
                'available_slots' => $equipment->max_slots - $equipment->reserved_today,
                'available_quantity' => $equipment->available_quantity,
                'total_quantity' => $equipment->total_quantity,
            ];
        });
        return Inertia::render('student/equipment-reservation', [
            'equipments' => $equipments,
            'remainingReservations' => $this->getRemainingReservations('equipment'),
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
            'remainingReservations' => $this->getRemainingReservations('seat'),
        ]);
    }

    public function bookReservationCreate(Request $request)
    {
        if (!$this->canMakeReservation('book')) {
            return back()->withErrors([
                'limit' => 'You have reached the maximum limit of ' . self::MAX_DAILY_RESERVATIONS . ' book reservations per day. Please try again tomorrow.'
            ]);
        }

        $request->validate([
            'book_id' => 'required|exists:books,id',
        ]);

        $book = Books::findOrFail($request->book_id);
        
        // Reset if last reset was not today
        if ($book->last_reset_date != now()->toDateString()) {
            $book->update([
                'reserved_today' => 0,
                'last_reset_date' => now()->toDateString(),
            ]);
            $book->refresh();
        }
        
        // Check if book has available slots
        if ($book->reserved_today >= $book->max_slots) {
            return back()->withErrors([
                'slots' => 'This book has reached its maximum reservation limit for today. Please try again tomorrow.'
            ]);
        }

        // Check if book has available quantity
        if ($book->available_quantity <= 0) {
            return back()->withErrors([
                'quantity' => 'This book is currently out of stock. Please try again later.'
            ]);
        }

        BookReservation::create([
            'user_id' => $this->userId(),
            'book_id' => $request->book_id,
            'start_time' => now(),
            'end_time' => now()->addDays(3),
        ]);

        // Increment reserved_today counter
        $book->increment('reserved_today');
        
        // Decrement available quantity
        $book->decrement('available_quantity');
        
        // Update status to Unavailable if all slots are taken or no stock
        if ($book->reserved_today >= $book->max_slots || $book->available_quantity <= 0) {
            $book->update(['status' => 'Unavailable']);
        }

        $this->incrementReservationCount('book');

        return redirect()->route('student.myBookReservation')->with(['success' => 'You have successfully reserved the book.']);
    }

    public function seatReservationCreate(Request $request)
    {
        if (!$this->canMakeReservation('seat')) {
            return back()->withErrors([
                'limit' => 'You have reached the maximum limit of ' . self::MAX_DAILY_RESERVATIONS . ' seat reservations per day. Please try again tomorrow.'
            ]);
        }

        $request->validate([
            'seat' => 'required|exists:study_space,id',
            'reason' => 'nullable|string|max:255',
        ]);

        $startTime = now();
        $endTime = now()->addHours(2); // Maximum stay is 2 hours

        SeatReservation::create([
            'user_id' => $this->userId(),
            'reserved_seat' => $request->seat,
            'reason' => $request->reason,
            'start_time' => $startTime,
            'end_time' => $endTime,
        ]);

        StudySpace::where('id', $request->seat)->update(['status' => 'In Use']);

        $this->incrementReservationCount('seat');

        return redirect()->route('student.mySeatReservation')->with(['success' => 'You have successfully reserved the seat for 2 hours.']);
    }

    public function equipmentReservationCreate(Request $request)
    {
        if (!$this->canMakeReservation('equipment')) {
            return back()->withErrors([
                'limit' => 'You have reached the maximum limit of ' . self::MAX_DAILY_RESERVATIONS . ' equipment reservations per day. Please try again tomorrow.'
            ]);
        }

        $request->validate([
            'equipment' => 'required|exists:equipments,id',
        ]);

        $equipment = Equipment::findOrFail($request->equipment);
        
        // Reset if last reset was not today
        if ($equipment->last_reset_date != now()->toDateString()) {
            $equipment->update([
                'reserved_today' => 0,
                'last_reset_date' => now()->toDateString(),
            ]);
            $equipment->refresh();
        }
        
        // Check if equipment has available slots
        if ($equipment->reserved_today >= $equipment->max_slots) {
            return back()->withErrors([
                'slots' => 'This equipment has reached its maximum reservation limit for today. Please try again tomorrow.'
            ]);
        }

        // Check if equipment has available quantity
        if ($equipment->available_quantity <= 0) {
            return back()->withErrors([
                'quantity' => 'This equipment is currently out of stock. Please try again later.'
            ]);
        }

        EquipmentReservation::create([
            'user_id' => $this->userId(),
            'equipment_id' => $request->equipment,
            'start_time' => now(),
            'end_time' => now()->addDays(3),
        ]);

        // Increment reserved_today counter
        $equipment->increment('reserved_today');
        
        // Decrement available quantity
        $equipment->decrement('available_quantity');
        
        // Update status to In Use if all slots are taken or no stock
        if ($equipment->reserved_today >= $equipment->max_slots || $equipment->available_quantity <= 0) {
            $equipment->update(['status' => 'In Use']);
        }

        $this->incrementReservationCount('equipment');

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
                    'author' => $book->author,
                    'image' => $book->image ? asset('storage/' . $book->image) : null,
                    'description' => $book->description,
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
                    'image' => $equipment->image ? asset('storage/' . $equipment->image) : null,
                    'description' => $equipment->description,
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
