<?php

namespace App\Http\Controllers;

use App\Events\MessageMedecin;
use App\Events\MessagePatient;
use App\Models\Consultation;
use App\Models\Medecin;
use App\Models\Message as ModelsMessage;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Message extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function fetchMessages(Request $request) {
        $data = array();
        $consultation = Consultation::where('id', $request->id)->first();
        $messages = ModelsMessage::all();
        $patient = Patient::where('email', $request->user)->first();
        $medecin = Medecin::where('email', $request->user)->first();
        $i = 0;
        foreach($messages as $m) {
            if ($medecin) {
                $patient = Patient::where('id', $consultation->patient_id)->first();
                if ($m->envoyeur_id === $patient->id && $m->envoyeur_type === "App\Models\Patient") {
                    $data[$i] = array(
                        'id' => $m->id,
                        'contenu' => $m->contenu,
                        'user' => ucwords($patient->nom) . ' ' . ucwords($patient->prenom),
                        'date' => date('d/m/Y H:i:s', strtotime($m->created_at)),
                        'sent_by' => 'patient'
                    );
                }else{
                    if ($m->envoyeur_id === $medecin->id && $m->envoyeur_type === "App\Models\Medecin"){
                        $data[$i] = array(
                            'id' => $m->id,
                            'contenu' => $m->contenu,
                            'user' => ucwords($medecin->nom) . ' ' . ucwords($medecin->prenom),
                            'date' => date('d/m/Y H:i:s', strtotime($m->created_at)),
                            'sent_by' => 'medecin'
                        );
                    }
                }
                $i += 1;
            }else{
                $medecin = Medecin::where('id', $m->envoyeur_id)->first();
                if ($m->envoyeur_id === $patient->id && $m->envoyeur_type === "App\Models\Patient") {
                    $data[$i] = array(
                        'id' => $m->id,
                        'contenu' => $m->contenu,
                        'user' => ucwords($patient->nom) . ' ' . ucwords($patient->prenom),
                        'date' => date('d/m/Y H:i:s', strtotime($m->created_at)),
                        'sent_by' => 'patient'
                    );
                }else{
                    if ($m->envoyeur_id === $medecin->id && $m->envoyeur_type === "App\Models\Medecin"){
                        $data[$i] = array(
                            'id' => $m->id,
                            'contenu' => $m->contenu,
                            'user' => ucwords($medecin->nom) . ' ' . ucwords($medecin->prenom),
                            'date' => date('d/m/Y H:i:s', strtotime($m->created_at)),
                            'sent_by' => 'medecin'
                        );
                    }
                }
                $i += 1;
            }
        }

        return response()->json([
            'status' => true,
            'details' => $data
        ]);
    }

    public function addMessage(Request $request) {
        $patient = Patient::where('email', $request->user)->first();
        $medecin = Medecin::where('email', $request->user)->first();
        $consultation = Consultation::where('id', $request->id)->first();
        if ($patient) {
            $m = Medecin::where('email', $request->medecin_from)->first();
            $message = $patient->message()->create([
                'contenu' => $request->content,
                'destinataire' => $m->id,
                'consultation_id' => $consultation->id
            ]);
            broadcast(new MessagePatient($patient, $message))->toOthers();
        }
        else{
            $p = Patient::where('id', $consultation->patient_id)->first();
            if (!ModelsMessage::where('envoyeur_id', $medecin->id)->where('envoyeur_type', "App\Models\Medecin")
            ->where('consultation_id', $consultation->id)->first()){
                $message = $medecin->message()->create([
                    'contenu' => $request->content,
                    'destinataire' => $p->id,
                    'consultation_id' => $consultation->id,
                    'boiteDialogue' => true
                ]);
            }else{
                $message = $medecin->message()->create([
                    'contenu' => $request->content,
                    'destinataire' => $p->id,
                    'consultation_id' => $consultation->id
                ]);
            }
            broadcast(new MessageMedecin($medecin, $message))->toOthers();
        }

        return response()->json([
            'status' => true,
            'message_sent' => 1
        ]);
    }

    public function checkIfMessageExists($user) {
        $patient = Patient::where('email', $user)->first();
        $medecin = Medecin::where('email', $user)->first();
        if ($patient) {
            if (ModelsMessage::where('destinataire', $patient->id)->first()){
                return true;
            }else{
                return false;
            }
        }else{
            if (ModelsMessage::where('envoyeur_id', $medecin->id)
            ->where('envoyeur_type', "App\Models\Medecin")->first()){
                return true;
            }else{
                return false;
            }
        }
    }

    public function checkIfBoiteExists(Request $request) {
        if (ModelsMessage::where('consultation_id', $request->id)->where('boiteDialogue', true)->first()){
            return response()->json([
                'exists' => 1
            ]);
        }else{
            return response()->json([
                'exists' => 0
            ]);
        }
    }

    public function getMessages(Request $request) {
        $data = array();
        if ($this->checkIfMessageExists($request->user)) {
            $messages = ModelsMessage::all();
            $patient = Patient::where('email', $request->user)->first();
            $medecin = Medecin::where('email', $request->user)->first();
            $i = 0;
            if ($patient){
                foreach($messages as $message) {
                    if ($message->boiteDialogue === true) {
                        $consultation = Consultation::where('id', $message->consultation_id)->first();
                        $medecin = Medecin::where('id', $message->envoyeur_id)->first();
                        $data[$i] = array(
                            'id' => $consultation->id,
                            'type' => $consultation->typeConsultation,
                            'date' => date('d/m/Y H:i:s', strtotime($message->created_at)),
                            'from' => ucwords($medecin->nom) . ' ' . ucwords($medecin->prenom),
                            'email' => $medecin->email
                        );
                        $i += 1;
                    }
                }
            }else{
                foreach($messages as $message) {
                    if ($message->boiteDialogue === true) {
                        $consultation = Consultation::where('id', $message->consultation_id)->first();
                        $patient = Patient::where('id', $consultation->patient_id)->first();
                        $data[$i] = array(
                            'id' => $consultation->id,
                            'type' => $consultation->typeConsultation,
                            'date' => date('d/m/Y H:i:s', strtotime($message->created_at)),
                            'from' => ucwords($medecin->nom) . ' ' . ucwords($medecin->prenom),
                            'to' => ucwords($patient->nom) . ' ' . ucwords($patient->prenom),
                            'email' => $medecin->email
                        );
                        $i += 1;
                    }
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

    public function deleteBoiteDialogue(Request $request) {
        $boite = ModelsMessage::where('consultation_id', $request->id)->where('boiteDialogue', true)->first();
        if ($boite) {
            $boite->delete();
            return response()->json([
                'status' => true,
                'message' => 'Boite de dialogue suppprimée avec succès'
            ]);
        }else{
            return response()->json([
                'status' => false
            ]);
        }
    }
}
