<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

use App\Models\Books;

class BookController extends Controller
{
    public function index()
    {
        $books = Books::get()->map(function ($book) {
            return [
                'id' => $book->id,
                'title' => $book->title,
                'author' => $book->author,
                'status' => $book->status,
                'created_at' => $book->created_at->format('d/m/Y H:i:s'),
                'updated_at' => $book->updated_at->format('d/m/Y H:i:s'),
            ];
        });

        return Inertia::render('modules/books', [
            'books' => $books,
        ]);
    }

    public function create()
    {
        return Inertia::render('modules/create/create-book');
    }


    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'status' => 'required|string|in:Available,Unavailable',
        ]);

        Books::create($request->all());

        return redirect()->route('books')->with('success', 'Book created successfully');
    }

    public function edit(string $id)
    {

        if (!$id) {
            return back()->with('error', 'Book identifier not found');
        }

        $book = Books::find($id);

        if (!$book) {
            return back()->with('error', 'Book not found');
        }

        return Inertia::render('modules/update/update-book', [
            'book' => $book,
        ]);
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'status' => 'required|string|in:Available,Unavailable',
        ]);

        Books::where('id', $id)->update($request->all());

        return redirect()->route('books')->with('success', 'Book updated successfully');
    }
}
