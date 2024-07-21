<?php

namespace App\Http\Controllers;

use App\Models\Medecin;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Login extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function check_login(Request $request) {
        $medecin = Medecin::where('email', $request->email)->first();
        $patient = Patient::where('email', $request->email)->first();
        if ($patient) {
            if (Auth::guard('patient')->attempt(['email' => $request->email, 'password' => $request->password])){
                $request->session()->regenerate();
                session(['type' => 'patient']);
                return response()->json([
                    'status' => true,
                    'loggedIn' => 1,
                    'type' => 'patient',
                    'message' => 'Utilisateur connecté avec succès',
                ]);
            }else{
                return response()->json([
                    'status' => false,
                    'loggedIn' => 0,
                    'message' => 'Email ou mot de passe incorrectes',
                ], 401);
            }
        }else if ($medecin){
            if (Auth::guard('medecin')->attempt(['email' => $request->email, 'password' => $request->password])) {
                $request->session()->regenerate();
                session(['type' => 'medecin']);
                return response()->json([
                    'status' => true,
                    'loggedIn' => 1,
                    'type' => 'medecin',
                    'message' => 'Utilisateur connecté avec succès',
                ]);
            }else{
                return response()->json([
                    'status' => false,
                    'loggedIn' => 0,
                    'message' => 'Email ou mot de passe incorrectes'
                ], 401);
            }
        }else{
            return response()->json([
                'status' => false,
                'loggedIn' => 0,
                'message' => 'Email ou mot de passe incorrectes'
            ], 401);
        }
    }

    public function editPassword(Request $request) {
        $patient = Patient::where('email', $request->user)->first();
        $medecin = Medecin::where('email', $request->user)->first();
        if ($patient) {
            if(!Hash::check($request->oldPassword, $patient->password)){
                return response()->json([
                    'status' => false,
                    'message' => 'Mot de passe inexistante'
                ]);
            }else{
                $patient->password = Hash::make($request->newPassword);
                $patient->save();
                return response()->json([
                    'status' => true,
                    'message' => 'Mot de passe modifié avec succès'
                ]);
            }
        }else{
            if(!Hash::check($request->oldPassword, $medecin->password)){
                return response()->json([
                    'status' => false,
                    'message' => 'Mot de passe inexistante'
                ]);
            }else{
                $medecin->password = Hash::make($request->newPassword);
                $medecin->save();
                return response()->json([
                    'status' => true,
                    'message' => 'Mot de passe modifié avec succès'
                ]);
            }
        }
    }
}
