<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use Illuminate\Http\Request;
use App\Models\EquipmentReservation;
use App\Models\StudySpace;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Inertia\Inertia;

class EquipmentReservationController extends Controller
{
    public function index()
    {
        $equipmentReservations = EquipmentReservation::with('equipment', 'user')->get()->map(function ($equipmentReservation) {
            return [
                'id' => $equipmentReservation->id,
                'equipment' => $equipmentReservation->equipment->name,
                'equipment_id' => $equipmentReservation->equipment_id,
                'user' => $equipmentReservation->user->name,
                'user_id' => $equipmentReservation->user_id,
                'start_time' => $equipmentReservation->start_time->format('d/m/Y H:i:s'),
                'end_time' => $equipmentReservation->end_time->format('d/m/Y H:i:s'),
                'status' => $equipmentReservation->status,
                'created_at' => $equipmentReservation->created_at->format('d/m/Y H:i:s'),
                'updated_at' => $equipmentReservation->updated_at->format('d/m/Y H:i:s'),
            ];
        });
        return Inertia::render('modules/equipment-reservation', [
            'equipmentReservations' => $equipmentReservations,
        ]);
    }

    public function create()
    {
        $equipments = Equipment::get()->map(function ($row) {
            return [
                'id' => $row->id,
                'name' => $row->name,
                'status' => $row->status,
            ];
        });

        $users = User::role('user')->get()->map(function ($row) {
            return [
                'id' => $row->id,
                'name' => $row->name,
            ];
        });

        return Inertia::render('modules/create/create-equipment-reservation', [
            'equipments' => $equipments,
            'users' => $users,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'equipment_id' => 'required|exists:equipments,id',
            'status' => 'required|in:Pending,Approved,Rejected',
        ]);

        $request->merge([
            'start_time' => now(),
            'end_time' => now()->addDays(3),
        ]);

        $equipmentReservation = EquipmentReservation::where('user_id', '=', $request->user_id)
            ->whereDate('created_at', now())
            ->exists();

        if ($equipmentReservation) {
            return back()->withErrors([
                'user_id' => 'User already have a equipment reservation today'
            ]);
        } else {
            EquipmentReservation::create($request->all());

            Equipment::where('id', $request->equipment_id)->update([
                'status' => 'Unavailable',
            ]);

            return redirect()->route('equipment-reservations.index')->with('success', 'Equipment reservation created successfully');
        }
    }


    public function edit(string $id)
    {

        if (!$id) {
            return back()->with('error', 'Equipment reservation identifier not found');
        }

        $equipmentReservation = EquipmentReservation::select('id', 'user_id', 'status', 'equipment_id')->find($id);
        
        if (!$equipmentReservation) {
            return back()->with('error', 'Equipment reservation not found');
        }

        $equipments = Equipment::get()->map(function ($row) {
            return [
                'id' => $row->id,
                'name' => $row->name,
                'status' => $row->status,
            ];
        });

        $users = User::role('user')->get()->map(function ($row) {
            return [
                'id' => $row->id,
                'name' => $row->name,
            ];
        });

        return Inertia::render('modules/update/update-equipment-reservation', [
            'equipmentReservation' => $equipmentReservation,
            'equipments' => $equipments,
            'users' => $users,
        ]);
    }

    public function update(Request $request, string $id)
    {
        if (!$id) {
            return back()->with('error', 'Equipment reservation identifier not found');
        }

        $equipmentReservation = EquipmentReservation::find($id);

        if (!$equipmentReservation) {
            return back()->with('error', 'Equipment reservation not found');
        }

        $request->validate([
            'user_id' => 'required|exists:users,id',
            'equipment_id' => 'required|exists:equipments,id',
            'status' => 'required|in:Pending,Approved,Rejected',
        ]);

        $equipmentReservation->update($request->all());

        return redirect()->route('equipment-reservations.index')->with('success', 'Equipment reservation updated successfully');
    }


    public function destroy(string $id)
    {
        if (!$id) {
            return back()->with('error', 'Equipment reservation identifier not found');
        }

        $equipmentReservation = EquipmentReservation::find($id);

        if (!$equipmentReservation) {
            return back()->with('error', 'Equipment reservation not found');
        }

        $equipmentReservation->delete();

        return redirect()->route('equipment-reservations.index')->with('success', 'Equipment reservation deleted successfully');
    }
}
