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
                'image' => $book->image ? asset('storage/' . $book->image) : null,
                'description' => $book->description,
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
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable|string',
            'status' => 'required|string|in:Available,Unavailable',
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('books', 'public');
            $data['image'] = $imagePath;
        }

        Books::create($data);

        return redirect()->route('books.index')->with('success', 'Book created successfully');
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
            'book' => [
                'id' => $book->id,
                'title' => $book->title,
                'author' => $book->author,
                'image' => $book->image ? asset('storage/' . $book->image) : null,
                'description' => $book->description,
                'status' => $book->status,
            ],
        ]);
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable|string',
            'status' => 'required|string|in:Available,Unavailable',
        ]);

        $book = Books::findOrFail($id);
        $data = $request->all();

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($book->image && \Storage::disk('public')->exists($book->image)) {
                \Storage::disk('public')->delete($book->image);
            }
            $imagePath = $request->file('image')->store('books', 'public');
            $data['image'] = $imagePath;
        }

        $book->update($data);

        return redirect()->route('books.index')->with('success', 'Book updated successfully');
    }

    public function destroy(string $id)
    {
        if (!$id) {
            return back()->with('error', 'Book identifier not found');
        }

        $book = Books::find($id);

        if (!$book) {
            return back()->with('error', 'Book not found');
        }

        // Delete image if exists
        if ($book->image && \Storage::disk('public')->exists($book->image)) {
            \Storage::disk('public')->delete($book->image);
        }

        $book->delete();

        return redirect()->route('books.index')->with('success', 'Book deleted successfully');
    }
}
