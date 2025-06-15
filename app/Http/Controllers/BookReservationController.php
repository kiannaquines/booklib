<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\BookReservation;

class BookReservationController extends Controller
{
    public function index()
    {
        $bookReservations = BookReservation::get()->map(function ($book) {
            return [
                'id' => $book->id,
                'title' => $book->title,
                'author' => $book->author,
                'status' => $book->status,
                'created_at' => $book->created_at->format('d/m/Y H:i:s'),
                'updated_at' => $book->updated_at->format('d/m/Y H:i:s'),
            ];
        });

        return Inertia::render('modules/book-reservation', [
            'books' => $bookReservations,
        ]);
    }
}
