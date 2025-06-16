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

        return redirect()->route('study-spaces')->with('success', 'Study space created successfully');
    }
}
