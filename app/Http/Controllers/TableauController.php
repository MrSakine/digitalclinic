<?php

namespace App\Http\Controllers;

use App\Models\Medecin;
use App\Models\Patient;
use App\Models\RendezVous;
use App\Models\Consultation;
use Illuminate\Http\Request;
use App\Models\TraiterConsultation;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class TableauController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    public function getTableauPrincipal() {
        $consultation = Consultation::all()->toArray();
        $rdv = RendezVous::all()->toArray();
        $traitees = TraiterConsultation::all()->toArray();
        $patients = Patient::all()->toArray();
        $medecins = Medecin::all()->toArray();

        return response()->json([
            'status' => true,
            'consultations' => sizeof($consultation),
            'rendezvous' => sizeof($rdv),
            'traitees' => sizeof($traitees),
            'patients' => sizeof($patients),
            'medecins' => sizeof($medecins)
        ]);
    }

    public function getPatientTb(Request $request) {
        $patient = Patient::where('email', $request->user)->first();
        $consultations = Consultation::where('patient_id', $patient->id)->get()->toArray();
        $rdv = RendezVous::where('patient_id', $patient->id)->get()->toArray();
        $traitees = TraiterConsultation::where('for_patient', $patient->id)->get()->toArray();

        return response()->json([
            'status' => true,
            'user' => ucwords($patient->nom) . ' ' . ucwords($patient->prenom),
            'consultations' => sizeof($consultations),
            'rdv' => sizeof($rdv),
            'traitees' => sizeof($traitees)
        ]);
    }
}
