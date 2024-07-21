<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Logout extends Controller
{
    public $isPatient;
    public $isMedecin;

    public function __construct()
    {
        $this->isPatient = Auth::guard('patient')->check();
        $this->isMedecin = Auth::guard('medecin')->check();
    }

    public function logout(Request $request) {
        if ($this->isPatient) {
            Auth::guard('patient')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }
        else{
            Auth::guard('medecin')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }

        return response()->json([
            'status' => true,
            'message' => 'Déconnexion réussi avec succès'
        ]);
    }
}
