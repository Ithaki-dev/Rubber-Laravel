<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display users management page.
     */
    public function users()
    {
        $users = User::where('role', '!=', 'admin')->latest()->paginate(20);
        return view('admin.users', compact('users'));
    }

    /**
     * Toggle user status (active/inactive).
     */
    public function toggleStatus(User $user)
    {
        // Prevent admin from deactivating themselves
        if ($user->role === 'admin') {
            return back()->with('error', 'No puedes modificar el estado de un administrador.');
        }

        $newStatus = $user->status === 'active' ? 'inactive' : 'active';
        $user->update(['status' => $newStatus]);

        return back()->with('success', 'Estado del usuario actualizado.');
    }
}
