<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class User extends Controller
{
    public function logout(Request $request) {
        if (Auth::guard('patient')->user()){
            Auth::guard('patient')->logout();
        }else{
            Auth::guard('medecin')->logout();
        }
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        $message = 'Successfully logged out';
        return response()->json([
            'status' => true,
            'message' => $message
        ]);
    }
}
