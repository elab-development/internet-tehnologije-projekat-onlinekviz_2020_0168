<?php

namespace App\Http\Controllers;

use App\Models\Pitanje;
use Illuminate\Http\Request;
use App\Http\Resources\PitanjeResource;


class PitanjeController extends Controller
{

    public function index()
    {
        $pitanja = Pitanje::all();
        return PitanjeResource::collection($pitanja);
    }

    public function store(Request $request)
    {
    $request->validate([
        'tekst_pitanja' => 'required|string|max:255',
    ]);

    $pitanje = Pitanje::create([
        'tekst_pitanja' => $request->input('tekst_pitanja'),
    ]);

    return response()->json(['message' => 'Pitanje je uspešno kreirano', 'data' => new PitanjeResource($pitanje)], 201);
    }

    public function show($id)
    {
        $pitanje = Pitanje::with('odgovori')->findOrFail($id);
        return new PitanjeResource($pitanje);
    }

    public function update(Request $request, $idPitanja)
    {
        $request->validate([
            'tekst_pitanja' => 'required|string|max:255',
        ]);
 
        $pitanje = Pitanje::findOrFail($idPitanja);
    
        $pitanje->update([
            'tekst_pitanja' => $request->input('tekst_pitanja'),
        ]);

        return response()->json(['message' => 'Pitanje je azurirano!']);
    }
    
    public function destroy($id)
    {
        $pitanje = Pitanje::findOrFail($id);
        $pitanje->delete();
        return response()->json('Obrisano pitanje.');    
    }
}
