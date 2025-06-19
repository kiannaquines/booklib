<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\BookReservation;
use App\Models\User;
use App\Models\EquipmentReservation;
use App\Models\Equipment;
use App\Models\StudySpace;
use App\Models\Books;

class StudentController extends Controller
{
    public function myBookReservation()
    {
        return Inertia::render('student/my-book-reservation');
    }

    public function myEquipmentReservation()
    {
        return Inertia::render('student/my-equipment-reservation');
    }

    public function bookEquipment()
    {
        return Inertia::render('student/book-equipment');
    }

    public function equipmentReservation()
    {
        return Inertia::render('student/equipment-reservation');
    }

    public function bookEquipmentCreate(Request $request)
    {
        $currentUser = $request->user()->id;
        $request->validate([]);
        // TODO: Save the request body
    }

    public function bookBookCreate(Request $request)
    {
        $currentUser = $request->user()->id;
        $request->validate([]);
        // TODO: Save the request body
    }

    public function bookEquipmentEdit(Request $request, string $id)
    {
        $currentUser = $request->user()->id;
        $request->validate([]);
        
        // TODO: Edit the request body
    }

    public function bookBookEdit(Request $request, string $id)
    {
        $currentUser = $request->user()->id;
        $request->validate(rules: []);


        // TODO: Edit the request body
    }

    public function bookEquipmentUpdate(Request $request, string $id)
    {
        $request->validate(rules: []);
        $reservation = EquipmentReservation::findOrFail($id);
        // TODO: Update the request body
    }

    public function bookBookUpdate(Request $request, string $id)
    {
        $request->validate(rules: []);
        $reservation = BookReservation::findOrFail($id);
        // TODO: Update the request body
    }

    public function bookEquipmentDestroy(Request $request, string $id)
    {
        $reservation = EquipmentReservation::findOrFail($id);
        $reservation->delete();

        return redirect()->route('student.myBookReservation')->with(['success', 'You have succesffuly removed your equipment reservation.']);
    }

    public function bookBookDestroy(Request $request, string $id)
    {
        $reservation = BookReservation::findOrFail($id);
        $reservation->delete();

        return redirect()->route('student.myBookReservation')->with(['success', 'You have succesffuly removed your book reservation.']);
    }
}
