<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ActivationController extends Controller
{
    public function activate(Request $request, $token)
    {
        try {
            $decoded = base64_decode($token);
            $parts = explode('|', $decoded);
            
            if (count($parts) !== 2) {
                return redirect()->route('login')->with('error', 'Token de activación inválido.');
            }
            
            $email = $parts[0];
            $timestamp = $parts[1];
            
            // Check if token is expired (24 hours)
            if (now()->timestamp - $timestamp > 86400) {
                return redirect()->route('login')->with('error', 'El token de activación ha expirado.');
            }
            
            $user = User::where('email', $email)->first();
            
            if (!$user) {
                return redirect()->route('login')->with('error', 'Usuario no encontrado.');
            }
            
            if ($user->status === 'active') {
                return redirect()->route('login')->with('info', 'Tu cuenta ya está activada.');
            }
            
            $user->update([
                'status' => 'active',
                'email_verified_at' => now(),
            ]);
            
            return redirect()->route('login')->with('success', 'Cuenta activada exitosamente. Ya puedes iniciar sesión.');
            
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Error al activar la cuenta.');
        }
    }
}
