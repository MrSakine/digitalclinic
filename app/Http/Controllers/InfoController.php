<?php

namespace App\Http\Controllers;

use App\Models\Medecin;
use App\Models\Message;
use App\Models\Patient;
use App\Models\Consultation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class InfoController extends Controller
{
    public function getPatientInfo(Request $request) {
        $consultation = Consultation::where('id', $request->id)->first();
        if ($consultation) {
            $patient = Patient::where('id', $consultation->patient_id)->first();
            $dobPatient = explode('-', $patient->dateNaissance)[0];

            return response()->json([
                'status' => true,
                'details' => array(
                    'nom' => $patient->nom,
                    'prenom' => $patient->prenom,
                    'adresse' => $patient->adresse,
                    'age' => date('Y') - $dobPatient,
                    'genre' => $patient->genre
                )
            ]);
        }
        else{
            return response()->json([
                'status' => false
            ]);
        }
    }

    public function getMedecinInfo(Request $request) {
        $message = Message::where('consultation_id', $request->id)->first();
        if ($message) {
            $medecin = Medecin::where('id', $message->envoyeur_id)->first();
            $dobPatient = explode('-', $medecin->dateNaissance)[0];

            return response()->json([
                'status' => true,
                'details' => array(
                    'nom' => $medecin->nom,
                    'prenom' => $medecin->prenom,
                    'adresse' => $medecin->adresse,
                    'age' => date('Y') - $dobPatient,
                    'genre' => $medecin->genre
                )
            ]);
        }
        else{
            return response()->json([
                'status' => false
            ]);
        }
    }

    public function editCred(Request $request) {
        if (Auth::guard('patient')->check()) {
            if ($request->option === 'cred') {
                Patient::where('id', Auth::guard('patient')->user()->id)->update([
                    'email' => $request->email,
                    'password' => Hash::make($request->password)
                ]);
            }else{
                Patient::where('id', Auth::guard('patient')->user()->id)->update([
                    'prenom' => $request->f,
                    'nom' => $request->l,
                    'adresse' => $request->a,
                    'telephone' => $request->n
                ]);
            }
        }else{
            if ($request->option === 'cred') {
                Medecin::where('id', Auth::guard('medecin')->user()->id)->update([
                    'email' => $request->email,
                    'password' => Hash::make($request->password)
                ]);
            }else{
                Medecin::where('id', Auth::guard('medecin')->user()->id)->update([
                    'prenom' => $request->f,
                    'nom' => $request->l,
                    'adresse' => $request->a,
                    'telephone' => $request->n
                ]);
            }
        }

        return response()->json([
            'status' => true
        ]);
    }
}
