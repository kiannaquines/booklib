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
                'image' => $equipment->image ? asset('storage/' . $equipment->image) : null,
                'description' => $equipment->description,
                'status' => $equipment->status,
                'created_at' => $equipment->created_at->format('d/m/Y h:i:s A'),
                'updated_at' => $equipment->updated_at->format('d/m/Y h:i:s A'),
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
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable|string',
            'status' => 'required|string|in:Available,Unavailable',
            'total_quantity' => 'required|integer|min:1',
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('equipments', 'public');
            $data['image'] = $imagePath;
        }

        // Set available_quantity equal to total_quantity on creation
        $data['available_quantity'] = $request->total_quantity;

        Equipment::create($data);

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
            'equipment' => [
                'id' => $equipment->id,
                'name' => $equipment->name,
                'image' => $equipment->image ? asset('storage/' . $equipment->image) : null,
                'description' => $equipment->description,
                'status' => $equipment->status,
                'total_quantity' => $equipment->total_quantity,
            ],
        ]);
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable|string',
            'status' => 'required|string|in:Available,Unavailable',
            'total_quantity' => 'required|integer|min:1',
        ]);

        $equipment = Equipment::findOrFail($id);
        $data = $request->all();

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($equipment->image && \Storage::disk('public')->exists($equipment->image)) {
                \Storage::disk('public')->delete($equipment->image);
            }
            $imagePath = $request->file('image')->store('equipments', 'public');
            $data['image'] = $imagePath;
        }

        // Update available_quantity if total_quantity changed
        if ($request->total_quantity != $equipment->total_quantity) {
            $difference = $request->total_quantity - $equipment->total_quantity;
            $data['available_quantity'] = max(0, $equipment->available_quantity + $difference);
        }

        $equipment->update($data);

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

        // Delete image if exists
        if ($equipment->image && \Storage::disk('public')->exists($equipment->image)) {
            \Storage::disk('public')->delete($equipment->image);
        }

        $equipment->delete();

        return redirect()->route('equipments.index')->with('success', 'Equipment deleted successfully');
    }
}
