<?php

namespace App\Http\Controllers;

use App\Models\Rezultat;
use Illuminate\Http\Request;
use App\Http\Resources\RezultatResource;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Validator; 
use Illuminate\Support\Facades\Log;

class RezultatController extends Controller
{
    public function index()
    {
        $rezultati = Rezultat::all();
        return RezultatResource::collection($rezultati);
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


    public function store(Request $request)
    {
        try {
            Log::info('Saving result', $request->all());

            $rezultat = new Rezultat();
            $rezultat->naziv_sobe = $request->input('naziv_sobe');
            $rezultat->ime_igraca = $request->input('ime_igraca');
            $rezultat->trenutni_rezultat = $request->input('trenutni_rezultat');
            $rezultat->save();

            return response()->json(['message' => 'Result saved successfully'], 200);
        } catch (\Exception $e) {
            Log::error('Error saving result: ' . $e->getMessage());
            return response()->json(['message' => 'Error saving result', 'error' => $e->getMessage()], 500);
        }
    }

    public function getLastResults($roomName)
    {
        try {
            Log::info('Fetching last results for room', ['roomName' => $roomName]);

            $results = Rezultat::where('naziv_sobe', $roomName)
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get(['ime_igraca', 'trenutni_rezultat']);

            return response()->json($results, 200);
        } catch (\Exception $e) {
            Log::error('Error fetching results: ' . $e->getMessage());
            return response()->json(['message' => 'Error fetching results', 'error' => $e->getMessage()], 500);
        }
    }
    
}
