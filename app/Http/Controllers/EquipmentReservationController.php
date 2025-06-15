<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EquipmentReservation;
use Inertia\Inertia;

class EquipmentReservationController extends Controller
{
    public function index()
    {
        $equipmentReservations = EquipmentReservation::get()->map(function ($equipmentReservation) {
            return [
                'id' => $equipmentReservation->id,
                'equipment_id' => $equipmentReservation->equipment_id,
                'user_id' => $equipmentReservation->user_id,
                'study_space_id' => $equipmentReservation->study_space_id,
                'start_date' => $equipmentReservation->start_date->format('d/m/Y H:i:s'),
                'end_date' => $equipmentReservation->end_date->format('d/m/Y H:i:s'),
                'status' => $equipmentReservation->status,
                'created_at' => $equipmentReservation->created_at->format('d/m/Y H:i:s'),
                'updated_at' => $equipmentReservation->updated_at->format('d/m/Y H:i:s'),
            ];
        });
        return Inertia::render('modules/equipment-reservation', [
            'equipmentReservations' => $equipmentReservations,
        ]);
    }
}
