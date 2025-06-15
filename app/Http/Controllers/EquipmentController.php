<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Equipment;
use Inertia\Inertia;

class EquipmentController extends Controller
{
    public function index()
    {
        $equipments = Equipment::get()->map(function ($equipment) {
            return [
                'id' => $equipment->id,
                'name' => $equipment->name,
                'status' => $equipment->status,
                'created_at' => $equipment->created_at->format('d/m/Y H:i:s'),
                'updated_at' => $equipment->updated_at->format('d/m/Y H:i:s'),
            ];
        });
        return Inertia::render('modules/equipment', [
            'equipments' => $equipments,
        ]);
    }
}
