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

    public function create()
    {
        return Inertia::render('modules/create/create-equipment');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|string|in:Available,Unavailable',
        ]);

        Equipment::create($request->all());

        return redirect()->route('equipments.index')->with('success', 'Equipment created successfully');
    }

    public function edit(string $id)
    {
        if (!$id) {
            return back()->with('error', 'Equipment identifier not found');
        }

        $equipment = Equipment::find($id);

        if (!$equipment) {
            return back()->with('error', 'Equipment not found');
        }

        return Inertia::render('modules/update/update-equipment', [
            'equipment' => $equipment,
        ]);
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|string|in:Available,Unavailable',
        ]);

        $equipment = Equipment::findOrFail($id);

        $equipment->update($request->all());

        return redirect()->route('equipments.index')->with('success', 'Equipment updated successfully');
    }

    public function destroy(string $id)
    {
        if (!$id) {
            return back()->with('error', 'Equipment identifier not found');
        }

        $equipment = Equipment::find($id);

        if (!$equipment) {
            return back()->with('error', 'Equipment not found');
        }
        $equipment->delete();

        return redirect()->route('equipments.index')->with('success', 'Equipment deleted successfully');
    }
}
