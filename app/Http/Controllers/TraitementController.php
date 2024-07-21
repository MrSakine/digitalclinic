<?php

namespace App\Http\Controllers;

use App\Events\NewTraitement;
use App\Models\Medecin;
use App\Models\Consultation;
use Illuminate\Http\Request;
use App\Models\TraiterConsultation;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class TraitementController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function saveTraitement(Request $request) {
        $medecin = Medecin::where('email', $request->user)->first();
        $consultation = Consultation::where('id', $request->id)->first();
        $medecin->traiter()->create([
            'for_patient' => $consultation->patient_id,
            'for_patient_consultation' => $consultation->typeConsultation,
            'for_consultation' => $consultation->id
        ]);
        $medecin->resultat_consultation()->create([
            'conseil' => $request->resultat['conseil'],
            'observation' => $request->resultat['observation'],
            'diagnostic' => $request->resultat['diagnostic']
        ]);
        if ($request->ordonnances) {
            for($i=0; $i < sizeof($request->ordonnances['obj']); $i++) {
                $medecin->ordonnance_consultation()->create([
                    'medicament' => $request->ordonnances['obj'][$i]['medicament'],
                    'modeEmploi' => $request->ordonnances['obj'][$i]['modeEmploi'],
                    'quantite' => $request->ordonnances['obj'][$i]['quantite']
                ]);
            }
        }
        $consultation->traiter = true;
        $consultation->dateValidation = $request->date;
        $consultation->save();
        broadcast(new NewTraitement('Vous avez reçu un nouveau traitement'))->toOthers();

        return response()->json([
            'status' => true,
            'message' => 'Consultation traitée avec succès'
        ]);
    }
}
