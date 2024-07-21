<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\Medecin;
use App\Models\Message;
use App\Models\RendezVous;
use App\Models\Specialite;
use App\Models\Consultation;
use Illuminate\Http\Request;
use App\Models\TraiterConsultation;
use Illuminate\Support\Facades\Auth;

class PatientController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth.patient')->except('logout');
    }

    public function index() {
        return view('digitalclinic');
    }

    public function getTypeConsultationList() {
        $spes = Specialite::all();
        $data = [];
        $i = 0;

        foreach($spes as $spe) {
            $data[$i] = array(
                'id' => $spe->id,
                'type' => $spe->type,
                'prix' => $spe->prix,
                'desc' => $spe->description
            );
            $i += 1;
        }

        return response()->json(['status' => true, 'details' => $data]);
    }

    public function getStats() {
        $id = Auth::guard('patient')->user()->id;
        $consultations = Consultation::where('patient_id', $id)->get();
        $rendezvous = sizeof(RendezVous::where('patient_id', $id)->get());
        $messages = 0;
        $resultats = sizeof(TraiterConsultation::where('for_patient', $id)->get());
        foreach($consultations as $con) {
            if (Message::where('consultation_id', $con->id)->where('boiteDialogue', true)->first()) {
                $messages += 1;
            }
        }


        return response()->json([
            "consultations" => sizeof($consultations),
            "rendezvous" => $rendezvous,
            "messages" => $messages,
            "resultats" => $resultats
        ]);
    }

    public function getMeetingHours(Request $request) {
        $meds = Medecin::all();
        $data = [];
        $i = 0;
        foreach($meds as $med) {
            $spe = Specialite::where('type', $request->typeConsultation)->first();
            $agenda = Agenda::where('medecin_id', $med->id)->where('jour', $request->date)->first();
            $medSpe = explode(",", $med->specialite);
            if (in_array($spe->nom, $medSpe) && isset($agenda)) {
                $data[$i] = array(
                    'id' => $agenda->id,
                    'hours' => $agenda->disponibilite,
                    'medecin' => ucwords($med->nom) . ' ' . ucwords($med->prenom)
                );
                $i += 1;
            }
        }

        return response()->json([
            "status" => true,
            "details" => $data
        ]);
    }
}
