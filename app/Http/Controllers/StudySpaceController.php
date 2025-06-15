<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StudySpace;
use Inertia\Inertia;

class StudySpaceController extends Controller
{
    public function index()
    {
        $studySpaces = StudySpace::get()->map(function ($studySpace) {
            return [
                'id' => $studySpace->id,
                'name' => $studySpace->name,
                'status' => $studySpace->status,
                'created_at' => $studySpace->created_at->format('d/m/Y H:i:s'),
                'updated_at' => $studySpace->updated_at->format('d/m/Y H:i:s'),
            ];
        });
        return Inertia::render('modules/study-space', [
            'studySpaces' => $studySpaces,
        ]);
    }
}
