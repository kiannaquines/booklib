<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EquipmentReservation;
use Inertia\Inertia;

class EquipmentReservationController extends Controller
{
    public function index()
    {
        $equipmentReservations = EquipmentReservation::with('equipment', 'user', 'studySpace')->get()->map(function ($equipmentReservation) {
            return [
                'id' => $equipmentReservation->id,
                'equipment' => $equipmentReservation->equipment->name,
                'equipment_id' => $equipmentReservation->equipment_id,
                'user' => $equipmentReservation->user->name,
                'user_id' => $equipmentReservation->user_id,
                'study_space' => $equipmentReservation->studySpace->seat_number,
                'study_space_id' => $equipmentReservation->study_space_id,
                'start_time' => $equipmentReservation->start_time->format('d/m/Y H:i:s'),
                'end_time' => $equipmentReservation->end_time->format('d/m/Y H:i:s'),
                'created_at' => $equipmentReservation->created_at->format('d/m/Y H:i:s'),
                'updated_at' => $equipmentReservation->updated_at->format('d/m/Y H:i:s'),
            ];
        });
        return Inertia::render('modules/equipment-reservation', [
            'equipmentReservations' => $equipmentReservations,
        ]);
    }
}
