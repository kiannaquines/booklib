<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

use App\Models\Books;
use App\Models\BookCategory;

class BookController extends Controller
{
    public function index()
    {
        $books = Books::with('category')->get()->map(function ($book) {
            return [
                'id' => $book->id,
                'title' => $book->title,
                'author' => $book->author,
                'category' => $book->category ? $book->category->name : 'N/A',
                'category_id' => $book->category_id,
                'image' => $book->image ? asset('storage/' . $book->image) : null,
                'description' => $book->description,
                'status' => $book->status,
                'created_at' => $book->created_at->format('d/m/Y h:i:s A'),
                'updated_at' => $book->updated_at->format('d/m/Y h:i:s A'),
            ];
        });

        return Inertia::render('modules/books', [
            'books' => $books,
        ]);
    }

    public function create()
    {
        $categories = BookCategory::all()->map(function ($category) {
            return [
                'id' => $category->id,
                'name' => $category->name,
            ];
        });

        return Inertia::render('modules/create/create-book', [
            'categories' => $categories,
        ]);
    }


    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'category_id' => 'nullable|exists:book_categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable|string',
            'status' => 'required|string|in:Available,Unavailable',
            'total_quantity' => 'required|integer|min:1',
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('books', 'public');
            $data['image'] = $imagePath;
        }

        // Set available_quantity equal to total_quantity on creation
        $data['available_quantity'] = $request->total_quantity;

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

        $categories = BookCategory::all()->map(function ($category) {
            return [
                'id' => $category->id,
                'name' => $category->name,
            ];
        });

        return Inertia::render('modules/update/update-book', [
            'book' => [
                'id' => $book->id,
                'title' => $book->title,
                'author' => $book->author,
                'category_id' => $book->category_id,
                'image' => $book->image ? asset('storage/' . $book->image) : null,
                'description' => $book->description,
                'status' => $book->status,
                'total_quantity' => $book->total_quantity,
            ],
            'categories' => $categories,
        ]);
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'category_id' => 'nullable|exists:book_categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable|string',
            'status' => 'required|string|in:Available,Unavailable',
            'total_quantity' => 'required|integer|min:1',
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

        // Update available_quantity if total_quantity changed
        if ($request->total_quantity != $book->total_quantity) {
            $difference = $request->total_quantity - $book->total_quantity;
            $data['available_quantity'] = max(0, $book->available_quantity + $difference);
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
