<?php

namespace App\Http\Controllers;

use App\Events\NewConsultation;
use App\Models\Medecin;
use App\Models\Patient;
use App\Models\Resultat;
use App\Models\Ordonnance;
use App\Models\Consultation;
use Illuminate\Http\Request;
use App\Models\FicheConsultation;
use App\Models\Message;
use App\Models\Paiement;
use App\Models\Specialite;
use App\Models\TraiterConsultation;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;

class ConsultationController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function saveConsultation(Request $request) {
        $patient = Patient::where('email', $request->user)->first();
        $patient->consultation()->create([
            'typeConsultation' => $request->typeConsultation,
            'prixConsultation' => $request->prixConsultation,
            'traiter' => $request->traiter,
            'payer' => $request->payer,
            'dateCreation' => $request->dateCreation,
            'dateValidation' => $request->dateValidation,
        ]);
        $consultation = Consultation::where('dateCreation', $request->dateCreation)->first();
        $consultation->consultation_paiement()->create([
            'datePaiement' => $request->dateCreation,
            'montant' => $request->prixConsultation,
            'patient_id' => $patient->id
        ]);
        $consultation->fiche_consultation()->create([
            'temperature' => $request->temperature,
            'typeMaladie' => $request->typeMaladie,
            'descriptionMaladie' => $request->descriptionMaladie,
            'antecedentMedicaux' => $request->antecedentMedicaux,
            'traitementInitial' => $request->traitementInitial,
            'groupSangin' => $request->groupSangin
        ]);

        broadcast(new NewConsultation('Vous avez reçu une nouvelle consultation'))->toOthers();

        return response()->json([
            'status' => true,
            'message' => 'Demande de consultation ajoutée avec succès'
        ]);
    }

    public function getConsultations(Request $request) {
        $patient = Patient::where('email', $request->user)->first();
        $consultations = Consultation::where('patient_id', $patient->id)->get();
        $data = [];
        if ($consultations) {
            $i = 0 ;
            foreach($consultations as $consultation) {
                $fiches = FicheConsultation::where('consultation_id', $consultation->id)->first();
                $dobPatient = explode('-', $patient->dateNaissance)[0];
                if ($consultation->traiter === false) {
                    $data[$i] = array(
                        'id' => $consultation->id,
                        'type' => $consultation->typeConsultation,
                        'user' => ucwords($patient->nom) . ' ' . ucwords($patient->prenom),
                        'genre' => $patient->genre,
                        'adresse' => $patient->adresse,
                        'age' => date('Y') - $dobPatient,
                        'montant' => $consultation->prixConsultation,
                        'creation' => date('d/m/Y H:i:s', strtotime($consultation->dateCreation)),
                        'traitement' => $consultation->traiter ? "Traiter" : "En cours",
                        'temperature' => $fiches->temperature,
                        'typeMaladie' => $fiches->typeMaladie,
                        'descriptionMaladie' => $fiches->descriptionMaladie,
                        'antecedentMedicaux' => $fiches->antecedentMedicaux,
                        'traitementInitial' => $fiches->traitementInitial,
                        'groupSangin' => $fiches->groupSangin
                    );
                    $i += 1;
                }
            }
        } else{
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

    public function deleteConsultation(Request $request) {
        $patient = Patient::where('email', $request->user)->first();
        $consultation = Consultation::where('patient_id', $patient->id)->where('id', $request->id)->first();
        $messages = Message::where('consultation_id', $consultation->id)->get();
        $paiement = Paiement::where('consultation_paiement_id', $consultation->id)->first();
        $consultation->delete();
        $paiement->delete();
        foreach($messages as $message) {
            $message->delete();
        }
        return response()->json([
            'status' => true,
            'message' => 'Consultation suppprimée avec succès'
        ]);
    }

    public function getConsultation() {
        $consultations = Consultation::all();
        $medecin = Medecin::where('id', Auth::guard('medecin')->user()->id)->first();
        $speMed = strpos($medecin->specialite, ',') ? explode(',', $medecin->specialite) : array($medecin->specialite);
        $data = [];
        if ($consultations) {
            $i = 0;
            foreach($consultations as $consultation) {
                $patient = Patient::where('id', $consultation->patient_id)->first();
                $spe = Specialite::where('type', $consultation->typeConsultation)->first();
                if($consultation->traiter === false && in_array($spe->nom, $speMed)){
                    $data[$i] = array(
                        'id' => $consultation->id,
                        'user' => ucwords($patient->nom) . ' ' . ucwords($patient->prenom),
                        'type' => $consultation->typeConsultation,
                        'date' => date('d/m/Y H:i:s', strtotime($consultation->dateCreation)),
                        'prix' => $consultation->prixConsultation,
                        'genre' => $patient->genre
                    );
                    $i += 1;
                }
            }
            return response()->json([
                'status' => true,
                'details' => $data
            ]);
        }else{
            return response()->json([
                'status' => false,
                'details' => $data
            ]);
        }
    }

    public function getFullConsultations(Request $request) {
        $consultation = Consultation::where('id', $request->id)->first();
        $patient = Patient::where('id', $consultation->patient_id)->first();
        $fiche = FicheConsultation::where('consultation_id', $consultation->id)->first();
        if ($consultation) {
            $dobPatient = explode('-', $patient->dateNaissance)[0];
            return response()->json([
                'status' => true,
                'nom' => $patient->nom,
                'prenom' => $patient->prenom,
                'age' => date('Y') - $dobPatient,
                'genre' => $patient->genre,
                'adresse' => $patient->adresse,
                'date' => date('d/m/Y H:i:s', strtotime($consultation->dateCreation)),
                'type' => $consultation->typeConsultation,
                'temp' => $fiche->temperature,
                'groupSangin' => $fiche->groupSangin,
                'descriptionMaladie' => $fiche->descriptionMaladie,
                'antMedicaux' => $fiche->antecedentMedicaux,
                'traitementIntial' => $fiche->traitementInitial
            ]);
        }
    }

    public function getPatientTraiterConsultationsFull(Request $request) {
        $patient = Patient::where('email', $request->user)->first();
        $traites = TraiterConsultation::where('for_patient', $patient->id)->get();
        $dobPatient = explode('-', $patient->dateNaissance)[0];
        $data = array();
        if ($traites) {
            $i = 0;
            foreach($traites as $traiter) {
                $medecin = Medecin::where('id', $traiter->medecin_id)->first();
                $resultat = Resultat::where('medecin_id', $medecin->id)->where('created_at', $traiter->created_at)->first();
                $ordo = Ordonnance::where('medecin_id', $medecin->id)->where('created_at', $traiter->created_at)->get()->toArray();
                $consultation = Consultation::where('id', $traiter->for_consultation)->first();
                $fiche = FicheConsultation::where('consultation_id', $consultation->id)->first();
                $medecin = Medecin::where('id', $traiter->medecin_id)->first();
                $dobMedecin = explode('-', $medecin->dateNaissance)[0];
                $data[$i] = array(
                    'id' => $consultation->id,
                    'type' => $consultation->typeConsultation,
                    'montant' => $consultation->prixConsultation,
                    'user' => ucwords($patient->nom) . ' ' . ucwords($patient->prenom),
                    'nom' => $patient->nom,
                    'prenom' => $patient->prenom,
                    'age' => date('Y') - $dobPatient,
                    'genre' => $patient->genre,
                    'adresse' => $patient->adresse,
                    'date' => date('d/m/Y H:i:s', strtotime($consultation->dateCreation)),
                    'traiter' => $consultation->traiter,
                    'traiter_par' => ucwords($medecin->nom) . ' ' . ucwords($medecin->prenom),
                    'traiter_par_adresse' => $medecin->adresse,
                    'traiter_par_age' => date('Y') - $dobMedecin,
                    'dateV' => date('d/m/Y H:i:s', strtotime($consultation->dateValidation)),
                    'temp' => $fiche->temperature,
                    'groupSangin' => $fiche->groupSangin,
                    'typeMaladie' => $fiche->typeMaladie,
                    'descriptionMaladie' => $fiche->descriptionMaladie,
                    'antMedicaux' => $fiche->antecedentMedicaux,
                    'traitementInitial' => $fiche->traitementInitial,
                    'conseil' => $resultat->conseil,
                    'diagnostic' => $resultat->diagnostic,
                    'observation' => $resultat->observation,
                    'ordonnances' => $ordo
                );
                $i += 1;
            }

            return response()->json([
                'status' => true,
                'details' => $data
            ]);
        }else{
            return response()->json([
                'status' => false,
                'details' => $data
            ]);
        }
    }

    public function getMedecinTraiterConsultationsFull(Request $request) {
        $medecin = Medecin::where('email', $request->user)->first();
        $traites = TraiterConsultation::where('medecin_id', $medecin->id)->get();
        $data = array();
        $dobMedecin = explode('-', $medecin->dateNaissance)[0];
        if ($traites) {
            $i = 0;
            foreach($traites as $traiter) {
                $resultat = Resultat::where('medecin_id', $medecin->id)->where('created_at', $traiter->created_at)->first();
                $ordo = Ordonnance::where('medecin_id', $medecin->id)->where('created_at', $traiter->created_at)->get()->toArray();
                $consultation = Consultation::where('id', $traiter->for_consultation)->first();
                $fiche = FicheConsultation::where('consultation_id', $consultation->id)->first();
                $patient = Patient::where('id', $consultation->patient_id)->first();
                $dobPatient = explode('-', $patient->dateNaissance)[0];
                $data[$i] = array(
                    'id' => $consultation->id,
                    'type' => $consultation->typeConsultation,
                    'montant' => $consultation->prixConsultation,
                    'user' => ucwords($patient->nom) . ' ' . ucwords($patient->prenom),
                    'nom' => $patient->nom,
                    'prenom' => $patient->prenom,
                    'age' => date('Y') - $dobPatient,
                    'genre' => $patient->genre,
                    'adresse' => $patient->adresse,
                    'numero' => $patient->telephone,
                    'email' => $patient->email,
                    'date' => date('d/m/Y H:i:s', strtotime($consultation->dateCreation)),
                    'traiter' => $consultation->traiter,
                    'traiter_par' => ucwords($medecin->nom) . ' ' . ucwords($medecin->prenom),
                    'traiter_par_adresse' => $medecin->adresse,
                    'traiter_par_age' => date('Y') - $dobMedecin,
                    'traiter_par_numero' => $medecin->telephone,
                    'dateV' => date('d/m/Y H:i:s', strtotime($consultation->dateValidation)),
                    'temp' => $fiche->temperature,
                    'groupSangin' => $fiche->groupSangin,
                    'descriptionMaladie' => $fiche->descriptionMaladie,
                    'antMedicaux' => $fiche->antecedentMedicaux,
                    'traitementIntial' => $fiche->traitementInitial,
                    'conseil' => $resultat->conseil,
                    'diagnostic' => $resultat->diagnostic,
                    'observation' => $resultat->observation,
                    'ordonnances' => $ordo
                );
                $i += 1;
            }

            return response()->json([
                'status' => true,
                'details' => $data
            ]);
        }else{
            return response()->json([
                'status' => false,
                'details' => $data
            ]);
        }
    }
}
