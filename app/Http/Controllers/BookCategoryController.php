<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\BookCategory;

class BookCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = BookCategory::withCount('books')->get()->map(function ($category) {
            return [
                'id' => $category->id,
                'name' => $category->name,
                'description' => $category->description,
                'books_count' => $category->books_count,
                'created_at' => $category->created_at->format('d/m/Y h:i:s A'),
                'updated_at' => $category->updated_at->format('d/m/Y h:i:s A'),
            ];
        });

        return Inertia::render('modules/book-categories', [
            'categories' => $categories,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('modules/create/create-book-category');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:book_categories,name',
            'description' => 'nullable|string',
        ]);

        BookCategory::create($request->all());

        return redirect()->route('book-categories.index')->with('success', 'Book category created successfully');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $category = BookCategory::findOrFail($id);

        return Inertia::render('modules/update/update-book-category', [
            'category' => [
                'id' => $category->id,
                'name' => $category->name,
                'description' => $category->description,
            ],
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $category = BookCategory::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255|unique:book_categories,name,' . $id,
            'description' => 'nullable|string',
        ]);

        $category->update($request->all());

        return redirect()->route('book-categories.index')->with('success', 'Book category updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = BookCategory::findOrFail($id);
        $category->delete();

        return redirect()->route('book-categories.index')->with('success', 'Book category deleted successfully');
    }
}
