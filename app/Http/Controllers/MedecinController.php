<?php

namespace App\Http\Controllers;

use App\Models\Medecin;
use App\Models\Specialite;
use App\Models\Consultation;
use App\Models\Patient;
use App\Models\RendezVous;
use App\Models\TraiterConsultation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class MedecinController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        $this->middleware('auth.medecin')->except('logout');
    }

    public function index() {
        return view('digitalclinic');
    }

    public function getSpe() {
        return response()->json([
            'status' => true,
            'spe' => explode(",", Medecin::where('id', Auth::guard('medecin')->user()->id)->first()->specialite)
        ]);
    }

    public function getMedStats() {
        $consultations = Consultation::all();
        $rendezvous = RendezVous::all();
        $medecin = Medecin::where('id', Auth::guard('medecin')->user()->id)->first();
        $speMed = strpos($medecin->specialite, ',') ? explode(',', $medecin->specialite) : array($medecin->specialite);
        $cons_total = 0;
        $total_rdv = 0;
        $traitements = TraiterConsultation::where('medecin_id', $medecin->id)->get();
        foreach ($consultations as $cons) {
            $spe = Specialite::where('type', $cons->typeConsultation)->first();
            if($cons->traiter === false && in_array($spe->nom, $speMed)) {
                $cons_total += 1;
            }
        }

        foreach($rendezvous as $r) {
            $h = explode(',', $r->heureConsultation);
            $spe = Specialite::where('type', $r->typeConsultation)->first();
            $isMedSpe = in_array($spe->nom, $speMed);
            if (trim($h[1]) === $medecin->nom . ' ' . $medecin->prenom && $isMedSpe === true && !(date('Y-m-d') > date('Y-m-d', strtotime($r->created_at)))) {
                $total_rdv += 1;
            }
        }

        return response()->json([
            "status" => true,
            "consultations" => $cons_total,
            "traitements" => sizeof($traitements),
            "rendezvous" => $total_rdv
        ]);
    }

    public function getRendezVous() {
        $medecin = Medecin::where('id', Auth::guard('medecin')->user()->id)->first();
        $rendezvous = RendezVous::all();
        $data = [];
        $i = 0;
        foreach($rendezvous as $r) {
            $h = explode(',', $r->heureConsultation);
            $spe = Specialite::where('type', $r->typeConsultation)->first();
            $speMed = strpos($medecin->specialite, ',') ? explode(',', $medecin->specialite) : array($medecin->specialite);
            $isMedSpe = in_array($spe->nom, $speMed);
            $patient = Patient::where('id', $r->patient_id)->first();
            if (trim($h[1]) === trim($medecin->nom . ' ' . $medecin->prenom) && $isMedSpe === true) {
                $data[$i] = array(
                    'id' => $r->id,
                    'date' => date('d/m/Y H:i:s', strtotime($r->dateConsultation)),
                    'made_by' => $patient->nom . ' ' . $patient->prenom,
                    'type' => $r->typeConsultation,
                    'meeting' => $h[0],
                    'status' => date('Y-m-d') > date('Y-m-d', strtotime($r->created_at))
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
