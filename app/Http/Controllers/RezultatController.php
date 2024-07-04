<?php

namespace App\Http\Controllers;

use App\Models\Rezultat;
use Illuminate\Http\Request;
use App\Http\Resources\RezultatResource;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Validator; 

class RezultatController extends Controller
{
    public function index()
    {
        $rezultati = Rezultat::all();
        return RezultatResource::collection($rezultati);
    }

    public function store(Request $request)
    {
        $request->validate([
            'naziv_sobe' => 'required|string|max:255',
            'ime_igraca' => 'required|string|max:255',
            'trenutni_rezultat' => 'required|integer',
        ]);

        $rezultat = Rezultat::create([
            'naziv_sobe' => $request->input('naziv_sobe'),
            'ime_igraca' => $request->input('ime_igraca'),
            'trenutni_rezultat' => $request->input('trenutni_rezultat'),
        ]);

        return response()->json(['message' => 'Rezultat je uspešno kreiran', 'data'=> new RezultatResource($rezultat)], 201);
    }

    public function show($id)
    {
        $rezultat = Rezultat::findOrFail($id);
        return new RezultatResource($rezultat);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'naziv_sobe' => 'required|string|max:255',
            'ime_igraca' => 'required|string|max:255',
            'trenutni_rezultat' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $rezultat = Rezultat::create([
            'naziv_sobe' => $request->input('naziv_sobe'),
            'ime_igraca' => $request->input('ime_igraca'),
            'trenutni_rezultat' => $request->input('trenutni_rezultat'),
        ]);

        return response()->json(['message' => 'Rezultat je uspešno ažuriran']);
    }

    public function destroy($id)
    {
        $rezultat = Rezultat::findOrFail($id);
        $rezultat->delete();
        return response()->json('Obrisan rezultat.');    
    }
}
