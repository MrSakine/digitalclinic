<?php

namespace App\Http\Controllers;

use App\Models\Paiement;
use App\Models\Patient;
use App\Models\RendezVous;
use Illuminate\Http\Request;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class RendezVousController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function saveRendezVous(Request $request) {
        $patient = Patient::where('email', $request->user)->first();
        $patient->rendez_vous()->create([
            'typeConsultation' => $request->typeConsultation,
            'dateConsultation' => $request->date,
            'heureConsultation' => $request->heure,
            'prix' => $request->prix
        ]);
        $rendezvous = RendezVous::where('dateConsultation', $request->date)->first();
        $rendezvous->consultation_paiement()->create([
            'datePaiement' => $request->date,
            'montant' => $request->prix,
            'patient_id' => $patient->id
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Demande de rendez-vous ajoutée avec succès'
        ]);
    }

    public function getRendezVous(Request $request) {
        $patient = Patient::where('email', $request->user)->first();
        $rendezvous = RendezVous::where('patient_id', $patient->id)->get();
        $data = array();
        if ($rendezvous) {
            $i = 0;
            foreach($rendezvous as $rdv) {
                $dobPatient = explode('-', $patient->dateNaissance)[0];
                $data[$i] = array(
                    'id' => $rdv->id,
                    'user' => ucwords($patient->nom) . ' ' . ucwords($patient->prenom),
                    'adresse' => $patient->adresse,
                    'age' => date('Y') - $dobPatient,
                    'type' => $rdv->typeConsultation,
                    'date' => date('d/m/Y H:i:s', strtotime($rdv->dateConsultation)),
                    'meeting' => $rdv->heureConsultation,
                    'prix' => $rdv->prix
                );
                $i += 1;
            }
        }else{
            $data = [
                'status' => false,
                'message' => "Vous n'aviez pas encore fait de consultation"
            ];
        }

        return response()->json([
            'status' => true,
            'details' => $data
        ]);

    }

    public function deleteRendezVous(Request $request) {
        $patient = Patient::where('email', $request->user)->first();
        $rendezvous = RendezVous::where('patient_id', $patient->id)->where('id', $request->id)->first();
        $paiement = Paiement::where('consultation_paiement_id', $rendezvous->id)->first();
        $rendezvous->delete();
        $paiement->delete();
        return response()->json([
            'status' => true,
            'message' => 'Rendez-vous suppprimée avec succès'
        ]);
    }
}
