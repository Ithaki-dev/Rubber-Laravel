<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules;

class AdminController extends Controller
{
    /**
     * Display users management page.
     */
    public function users()
    {
        $users = User::latest()->paginate(20);
        return view('admin.users', compact('users'));
    }

    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        return view('admin.users-create');
    }

    /**
     * Store a newly created user.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'cedula' => 'required|string|max:20|unique:users',
            'birthdate' => 'required|date',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:20',
            'photo' => 'nullable|image|max:2048',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => 'required|in:admin,driver,passenger',
            'status' => 'required|in:active,pending,inactive',
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('photos', 'public');
        }

        User::create([
            'name' => $request->name,
            'surname' => $request->surname,
            'cedula' => $request->cedula,
            'birthdate' => $request->birthdate,
            'email' => $request->email,
            'phone' => $request->phone,
            'photo' => $photoPath,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'status' => $request->status,
            'email_verified_at' => $request->status === 'active' ? now() : null,
        ]);

        return redirect()->route('admin.users')->with('success', 'Usuario creado exitosamente.');
    }

    /**
     * Show the form for editing a user.
     */
    public function edit(User $user)
    {
        return view('admin.users-edit', compact('user'));
    }

    /**
     * Update the specified user.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'cedula' => 'required|string|max:20|unique:users,cedula,' . $user->id,
            'birthdate' => 'required|date',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'required|string|max:20',
            'photo' => 'nullable|image|max:2048',
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
            'role' => 'required|in:admin,driver,passenger',
            'status' => 'required|in:active,pending,inactive',
        ]);

        $data = $request->only(['name', 'surname', 'cedula', 'birthdate', 'email', 'phone', 'role', 'status']);

        if ($request->hasFile('photo')) {
            // Delete old photo
            if ($user->photo) {
                Storage::disk('public')->delete($user->photo);
            }
            $data['photo'] = $request->file('photo')->store('photos', 'public');
        }

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        // Update email_verified_at based on status
        if ($request->status === 'active' && !$user->email_verified_at) {
            $data['email_verified_at'] = now();
        }

        $user->update($data);

        return redirect()->route('admin.users')->with('success', 'Usuario actualizado exitosamente.');
    }

    /**
     * Remove the specified user.
     */
    public function destroy(User $user)
    {
        // Prevent deleting yourself
        if ($user->id === auth()->id()) {
            return back()->with('error', 'No puedes eliminar tu propia cuenta.');
        }

        // Delete photo if exists
        if ($user->photo) {
            Storage::disk('public')->delete($user->photo);
        }

        $user->delete();

        return redirect()->route('admin.users')->with('success', 'Usuario eliminado exitosamente.');
    }

    /**
     * Toggle user status (active/inactive).
     */
    public function toggleStatus(User $user)
    {
        // Prevent admin from deactivating themselves
        if ($user->id === auth()->id()) {
            return back()->with('error', 'No puedes modificar tu propio estado.');
        }

        $newStatus = $user->status === 'active' ? 'inactive' : 'active';
        $user->update([
            'status' => $newStatus,
            'email_verified_at' => $newStatus === 'active' ? now() : $user->email_verified_at,
        ]);

        return back()->with('success', 'Estado del usuario actualizado.');
    }
}
