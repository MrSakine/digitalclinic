<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\Medecin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AgendaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth.medecin')->except('logout');
    }

    public function getAgendas() {
        $agendas = Agenda::where('medecin_id', Auth::guard('medecin')->user()->id)->get();
        $data = [];
        $i = 0;
        foreach($agendas as $agenda) {
            $data[$i] = array(
                'id' => $agenda->id,
                'jour' => $agenda->jour,
                'disponibilite' => $agenda->disponibilite
            );
            $i += 1;
        }

        return response()->json([
            'status' => true,
            'details' => $data
        ]);
    }

    public function saveAgenda(Request $request) {
        $medecin = Medecin::where('id', Auth::guard('medecin')->user()->id)->first();
        $medecin->agenda()->create([
            'jour' => $request->jour,
            'disponibilite' => $request->disponibilite
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Nouvelle horaire ajoutée avec succès'
        ]);
    }

    public function editAgenda(Request $request, $jour) {
        Agenda::where('jour', $jour)->update([
            'jour' => $request->jour,
            'disponibilite' => $request->disponibilite
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Horaire modifiée avec succès'
        ]);
    }

    public function deleteAgenda($jour) {
        Agenda::where('jour', $jour)->delete();

        return response()->json([
            'status' => true,
            'message' => 'Horaire supprimée avec succès'
        ]);
    }
}
