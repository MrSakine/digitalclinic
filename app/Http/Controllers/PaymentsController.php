<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Paiement;
use App\Models\RendezVous;
use App\Models\Consultation;
use Illuminate\Http\Request;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class PaymentsController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function getPayments(Request $request) {
        $patient = Patient::where('email', $request->user)->first();
        $paiements = Paiement::all();
        $data = array();
        if ($paiements) {
            $i = 0;
            $j = null;
            $k = null;
            foreach($paiements as $paiement) {
                if ($paiement->consultation_paiement_type === 'App\Models\Consultation'){
                    $j = Consultation::where('id', $paiement->consultation_paiement_id)->first();
                    $k = Paiement::where('consultation_paiement_id', $j->id)->where('patient_id', $patient->id)->first();
                }else{
                    $j = RendezVous::where('id', $paiement->consultation_paiement_id)->first();
                    $k = Paiement::where('consultation_paiement_id', $j->id)->where('patient_id', $patient->id)->first();
                }
                if ($k) {
                    $data[$i] = array(
                        'user' => ucwords($patient->nom) . ' ' . ucwords($patient->prenom),
                        'id' => $j->id,
                        'type' => $j->typeConsultation,
                        'date' => date('d/m/Y H:i:s', strtotime($k->datePaiement)),
                        'montant' => $k->montant
                    );
                    $i += 1;
                }
            }
        }
        else{
            $data = [
                'status' => false,
                'message' => 'Vous n\'aviez pas encore fait de paiements'
            ];
        }
        return response()->json([
            'status' => true,
            'details' => $data,
        ]);
    }
}
