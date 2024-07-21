<?php

namespace App\Http\Controllers\App;

use App\Models\Medecin;
use App\Models\Patient;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }
    public function home() {
        $medecins = Medecin::all();
        $data = [];
        $i = 0;
        foreach($medecins as $medecin) {
            $data[$i] = array(
                'id' => $medecin->id,
                'nom' => $medecin->nom,
                'prenom' => $medecin->prenom,
                'genre' => $medecin->genre,
                'dob' => date('d/m/Y', strtotime($medecin->dateNaissance)),
                'adresse' => $medecin->adresse,
                'telephone' => $medecin->telephone,
                'email' => $medecin->email,
                'hopital' => $medecin->hopital,
                'specialite' => $medecin->specialite
            );
            $i += 1;
        }
        return response()->json(['status' => 'ok', 'details' => $data]);
    }

    public function addMedecin(Request $request) {
        if (Medecin::where('email', $request->email)->first() || Patient::where('email', $request->email)->first()) {
            return response()->json([
                'status' => false,
                'code' => 'EMAIL_EXIST',
                'message' => 'Cet email est déjà utilisé. Veuillez réessayer avec un nouveau'
            ]);
        }else if (Medecin::where('telephone', $request->phone)->first() || Patient::where('telephone', $request->phone)->first()) {
            return response()->json([
                'status' => false,
                'code' => 'NUMBER_EXIST',
                'message' => 'Ce numéro de téléphone est déjà utilisé. Veuillez réessayer avec un nouveau'
            ]);
        }
        else{
            Medecin::create([
                'nom' => $request->nom,
                'prenom' => $request->prenom,
                'genre' => $request->genre === "Homme" ? true : false,
                'dateNaissance' => $request->dob,
                'adresse' => $request->adresse,
                'telephone' => $request->phone,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'hopital' => $request->hopital,
                'specialite' => $request->specialties
            ]);
        }

        return response(['status' => true, 'code' => 'SUCCESS', 'message' => 'Nouveau médecin ajouté avec succès']);
    }

    public function editMedecin(Request $request, $id) {
        Medecin::where('id', $id)->where('email', $request->email)->update([
            'password' => Hash::make($request->password)
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Mot de passe modifié avec succès'
        ]);
    }

    public function deleteMedecin($id) {
        $medecin = Medecin::where('id', $id)->first();
        $messages = Message::where('envoyeur_id', $medecin->id)->where('envoyeur_type', 'App\Models\Medecin')->get();
        foreach($messages as $message) {
            $message->delete();
        }
        $medecin->delete();

        return response()->json(['status' => true, 'message' => 'ok']);
    }

    public function getPatients() {
        $patients = Patient::all();
        $data = [];
        $i = 0;
        foreach($patients as $patient) {
            $data[$i] = array(
                'id' => $patient->id,
                'nom' => $patient->nom,
                'prenom' => $patient->prenom,
                'genre' => $patient->genre,
                'dob' => date('d/m/Y', strtotime($patient->dateNaissance)),
                'adresse' => $patient->adresse,
                'telephone' => $patient->telephone,
                'email' => $patient->email
            );
            $i += 1;
        }
        return response()->json(['status' => 'ok', 'details' => $data]);
    }

    public function deletePatient($id) {
        $patient = Patient::where('id', $id)->first();
        $messages = Message::where('envoyeur_id', $patient->id)->where('envoyeur_type', 'App\Models\Patient')->get();
        foreach($messages as $message) {
            $message->delete();
        }
        $patient->delete();

        return response()->json(['status' => true, 'message' => 'ok']);
    }
}
