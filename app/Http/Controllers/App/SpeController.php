<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Models\Medecin;
use App\Models\Specialite;
use Illuminate\Http\Request;

class SpeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum')->except('logout');
    }

    public function setup() {
        $json = file_get_contents(public_path('storage/raw/specialites.json'));
        $json_data = json_decode($json);
        foreach($json_data as $j) {
            Specialite::create([
                'nom' => $j->name,
                'description' => $j->description,
                'type' => $j->type,
                'prix' => $j->prix,
            ]);
        }

        return response()->json(['status' => true, 'message' => 'ok']);
    }

    public function getSpes() {
        $spes = Specialite::all();
        $data = [];
        $i = 0;
        foreach($spes as $spe) {
            $data[$i] = array(
                'id' => $spe->id,
                'nom' => $spe->nom,
                'type' => $spe->type,
                'prix' => $spe->prix,
                'description' => $spe->description
            );
            $i += 1;
        }

        return response()->json(['status' => true, 'details' => $data]);
    }

    public function saveSpe(Request $request) {
        if (Specialite::where('nom', $request->spe)->first()) {
            return response()->json(['status' => false, 'message' => 'fail']);
        }else{
            Specialite::create([
                'nom' => $request->spe,
                'type' => $request->type,
                'prix' => $request->prix,
                'description' => $request->desc
            ]);

            return response()->json(['status' => true, 'message' => 'success']);
        }
    }

    public function editSpe(Request $request, $id) {
        Specialite::where('id', $id)->update([
            'nom' => $request->spe,
            'type' => $request->type,
            'prix' => $request->prix,
            'description' => $request->desc
        ]);

        return response()->json(['status' => true, 'message' => 'success']);
    }

    public function deleteSpe($id) {
        Specialite::where('id', $id)->first()->delete();

        return response()->json(['status' => true, 'message' => 'ok']);
    }

    public function editMedSpe(Request $request, $id) {
        Medecin::where('id', $id)->update([
            'specialite' => $request->spe
        ]);

        return response(['status' => true, 'code' => 'SUCCESS']);
    }
}
