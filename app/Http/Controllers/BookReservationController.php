<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\BookReservation;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Books;
use App\Models\StudySpace;
use Spatie\Permission\Models\Role;

class BookReservationController extends Controller
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

        return Inertia::render('modules/book-reservation', [
            'books' => $bookReservations,
        ]);
    }

    public function create()
    {

        $users = User::role('user')->get()->map(function ($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
            ];
        });

        $books = Books::get()->map(function ($book) {
            return [
                'id' => $book->id,
                'title' => $book->title,
                'status' => $book->status,
            ];
        });

        $spaces = StudySpace::get()->map(function ($space) {
            return [
                'id' => $space->id,
                'seat_number' => $space->seat_number,
                'status' => $space->status,
            ];
        });

        return Inertia::render('modules/create/create-book-reservation', [
            'users' => $users,
            'books' => $books,
            'spaces' => $spaces,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'book_id' => 'required|exists:books,id',
            'study_space_id' => 'required|exists:study_space,id',
        ]);

        $request->merge([
            'start_time' => now(),
            'end_time' => now()->addDays(3),
        ]);

        $bookReservation = BookReservation::where('user_id', $request->user_id)
            ->whereDate('created_at', now())
            ->exists();

        if ($bookReservation) {
            return back()->withErrors([
                'user_id' => 'User already have a book reservation today'
            ]);
        } else {
            BookReservation::create($request->all());

            Books::where('id', $request->book_id)->update([
                'status' => 'Unavailable',
            ]);

            StudySpace::where('id', $request->study_space_id)->update([
                'status' => 'Unavailable',
            ]);

            return redirect()->route('book-reservation')->with('success', 'Book reservation created successfully');
        }
    }

    public function edit(string $id)
    {

        if (!$id) {
            return back()->with('error', 'Book reservation identifier not found');
        }

        $bookReservation = BookReservation::select('id', 'user_id', 'book_id', 'study_space_id')->find($id);

        if (!$bookReservation) {
            return back()->with('error', 'Book reservation not found');
        }

        $users = User::role('user')->get()->map(function ($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
            ];
        });

        $books = Books::get()->map(function ($book) {
            return [
                'id' => $book->id,
                'title' => $book->title,
                'status' => $book->status,
            ];
        });

        $spaces = StudySpace::get()->map(function ($space) {
            return [
                'id' => $space->id,
                'seat_number' => $space->seat_number,
                'status' => $space->status,
            ];
        });



        return Inertia::render('modules/update/update-book-reservation', [
            'bookReservation' => $bookReservation,
            'users' => $users,
            'books' => $books,
            'spaces' => $spaces,
        ]);
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'book_id' => 'required|exists:books,id',
            'study_space_id' => 'required|exists:study_space,id',
        ]);

        $bookReservation = BookReservation::findOrFail($id);
        $bookReservation->update($request->all());

        return redirect()->route('book-reservation')->with('success', 'Book reservation updated successfully');
    }

    public function destroy(string $id)
    {
        if (!$id) {
            return back()->with('error', 'Book reservation identifier not found');
        }

        $bookReservation = BookReservation::find($id);

        if (!$bookReservation) {
            return back()->with('error', 'Book reservation not found');
        }
        $bookReservation->delete();

        return redirect()->route('book-reservation')->with('success', 'Book reservation deleted successfully');
    }
}
