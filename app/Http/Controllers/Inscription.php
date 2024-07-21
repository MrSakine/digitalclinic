<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Inscription extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function saveUser(Request $request) {
        $email = Patient::where('email', $request->email)->first();
        $numero = Patient::where('telephone', $request->number)->first();
        if ($email) {
            return response()->json([
                'status' => false,
                'error' => 'email',
                'message' => 'Email déjà prise'
            ]);
        } else if ($numero) {
            return response()->json([
                'status' => false,
                'error' => 'téléphone',
                'message' => 'Numéro de téléphone déjà pris'
            ]);
        } else {
            Patient::create([
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'nom' => $request->name,
                'prenom' => $request->secondName,
                'genre' => $request->genre,
                'dateNaissance' => $request->date,
                'adresse' => $request->adresse,
                'telephone' => $request->number
            ]);
            return response()->json([
                'status' => true,
                'message' => 'Inscription réussi avec succès'
            ]);
        }
    }
}
