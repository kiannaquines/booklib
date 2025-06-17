<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StudySpace;
use Inertia\Inertia;

class StudySpaceController extends Controller
{
    public function index()
    {
        $spaces = StudySpace::get()->map(function ($studySpace) {
            return [
                'id' => $studySpace->id,
                'seat_number' => $studySpace->seat_number,
                'status' => $studySpace->status,
                'created_at' => $studySpace->created_at->format('d/m/Y H:i:s'),
                'updated_at' => $studySpace->updated_at->format('d/m/Y H:i:s'),
            ];
        });
        return Inertia::render('modules/study-space', [
            'spaces' => $spaces,
        ]);
    }

    public function create()
    {
        return Inertia::render('modules/create/create-study-space');
    }

    public function store(Request $request)
    {
        $request->validate([
            'seat_number' => 'required|string|max:255',
            'status' => 'required|string|in:Available,Unavailable',
        ]);

        StudySpace::create($request->all());

        return redirect()->route('study-spaces.index')->with('success', 'Study space created successfully');
    }

    public function edit(string $id)
    {
        if (!$id) {
            return back()->with('error', 'Study space identifier not found');
        }

        $studySpace = StudySpace::find($id);

        if (!$studySpace) {
            return back()->with('error', 'Study space not found');
        }

        return Inertia::render('modules/update/update-study-space', [
            'studySpace' => $studySpace,
        ]);
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'seat_number' => 'required|string|max:255',
            'status' => 'required|string|in:Available,Unavailable',
        ]);

        $studySpace = StudySpace::findOrFail($id);

        $studySpace->update($request->all());

        return redirect()->route('study-spaces.index')->with('success', 'Study space updated successfully');
    }

    public function destroy(string $id)
    {
        if (!$id) {
            return back()->with('error', 'Study space identifier not found');
        }

        $studySpace = StudySpace::find($id);

        if (!$studySpace) {
            return back()->with('error', 'Study space not found');
        }

        $studySpace->delete();

        return redirect()->route('study-spaces.index')->with('success', 'Study space deleted successfully');
    }
}
