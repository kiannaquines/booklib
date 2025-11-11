<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::get()->map(function ($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'number' => $user->number,
                'created_at' => $user->created_at->format('d/m/Y h:i:s A'),
                'updated_at' => $user->updated_at->format('d/m/Y h:i:s A'),
            ];
        });

        return Inertia::render('modules/users', [
            'users' => $users,
        ]);
    }

    public function create()
    {
        return Inertia::render('modules/create/create-user');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'number' => 'required|string|max:255',
            'password' => 'required|string|max:255',
            'confirm_password' => 'required|string|max:255|same:password',
            'role' => 'required|string|in:user,admin',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'number' => $request->number,
            'password' => Hash::make($request->password),
        ])->assignRole($request->role);

        return redirect()->route('users.index')->with('success', 'User created successfully');
    }

    public function edit(string $id)
    {

        if (!$id) {
            return back()->with('error', 'User identifier not found');
        }

        $user = User::find($id);

        if (!$user) {
            return back()->with('error', 'User not found');
        }

        return Inertia::render('modules/update/update-user', [
            'user' => $user,
            'role' => $user->roles()->pluck('name')->first(),
        ]);
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'number' => 'required|string|max:255',
            'role' => 'required|string|in:user,admin',
        ]);

        $user = User::findOrFail($id);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'number' => $request->number,
        ]);

        $user->syncRoles([$request->role]);

        return redirect()->route('users.index')->with('success', 'User updated successfully');
    }

    public function destroy(string $id)
    {
        if (!$id) {
            return back()->with('error', 'User identifier not found');
        }

        $user = User::findOrFail($id);

        if (!$user) {
            return back()->with('error', 'User not found');
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'User deleted successfully');
    }
}
