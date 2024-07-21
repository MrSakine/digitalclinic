<?php

namespace App\Http\Controllers;

use App\Models\Medecin;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function getUser() {
        if (Auth::guard('patient')->check()) {
            $patient = Patient::where('id', Auth::guard('patient')->user()->id)->first();
            return response()->json([
                'status' => true,
                'details' => array(
                    'email' => $patient->email,
                    'nom' => $patient->nom,
                    'prenom' => $patient->prenom,
                    'dob' => date('d/m/Y', strtotime($patient->dateNaissance)),
                    'adresse' => $patient->adresse,
                    'genre' => $patient->genre,
                    'telephone' => $patient->telephone,
                )
            ]);
        }else{
            $medecin = Medecin::where('id', Auth::guard('medecin')->user()->id)->first();
            return response()->json([
                'status' => true,
                'details' => array(
                    'email' => $medecin->email,
                    'nom' => $medecin->nom,
                    'prenom' => $medecin->prenom,
                    'dob' => date('d/m/Y', strtotime($medecin->dateNaissance)),
                    'adresse' => $medecin->adresse,
                    'genre' => $medecin->genre,
                    'telephone' => $medecin->telephone,
                )
            ]);
        }
    }
}
