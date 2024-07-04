<?php

namespace App\Http\Controllers;

use App\Models\Odgovor;
use Illuminate\Http\Request;
use App\Http\Resources\OdgovorResource;

class OdgovorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $odgovori = Odgovor::all();
        return OdgovorResource::collection($odgovori);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tekst_odgovora' => 'required|string|max:255',
            'tacan_odgovor' => 'required|boolean',
            'pitanje_id' => 'required|exists:pitanjes,id',
        ]);
    
        $odgovor = Odgovor::create([
            'tekst_odgovora' => $request->input('tekst_odgovora'),
            'tacan_odgovor' => $request->input('tacan_odgovor'),
            'pitanje_id' => $request->input('pitanje_id'),
        ]);
    
        return response()->json(['message' => 'Odgovor je uspešno kreiran!', 'data' => new OdgovorResource($odgovor)], 201);
    }
    
    /**
     * Display the specified resource.
     */
    public function show(Odgovor $odgovor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Odgovor $odgovor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'tekst_odgovora' => 'required|string|max:255',
            'tacan_odgovor' => 'required|boolean',
            'pitanje_id' => 'required|exists:pitanjes,id',
        ]);

        $odgovor = Odgovor::find($id);

        if (!$odgovor) {
            return response()->json(['error' => 'Odgovor ne postoji'], 404);
        }

        $odgovor->update([
            'tekst_odgovora' => $request->input('tekst_odgovora'),
            'tacan_odgovor' => $request->input('tacan_odgovor'),
            'pitanje_id' => $request->input('pitanje_id'),
        ]);
        $odgovor = Odgovor::find($id);

        return response()->json(['message' => 'Odgovor je ažuriran!', 'data' => new OdgovorResource($odgovor)]);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Odgovor $odgovor)
    {
        //
    }
}
