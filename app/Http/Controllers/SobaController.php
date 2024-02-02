<?php

namespace App\Http\Controllers;

use App\Models\Soba;
use Illuminate\Http\Request;
use App\Http\Resources\SobaResource;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Validator; 

class SobaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sobas = Soba::all();
        return [SobaResource::collection($sobas)];
    }   
    


    
     public function prikaziSobeNaOsnovuStatusa(Request $request)
    {
    $validator = Validator::make($request->all(), [
        'status' => 'required|in:privatna,javna',
        'min_maksimalan_broj_ucesnika' => 'nullable|integer|min:6',  
        'max_maksimalan_broj_ucesnika' => 'nullable|integer|max:8',  
        'page' => 'nullable|integer',
    ]);

    if ($validator->fails()) {
        return response()->json(['error' => $validator->errors()], 400);
    }

    $status = $request->input('status');
    $minBrojIgraca = $request->input('min_maksimalan_broj_igraca');
    $maxBrojIgraca = $request->input('max_maksimalan_broj_igraca');
    $page = $request->input('page', 1);

    
    $query = Soba::where('status', $status);

    
    if ($minBrojIgraca) {
        $query->where('maksimalan_broj_igraca', '>=', $minBrojIgraca);
    }

    
    if ($maxBrojIgraca) {
        $query->where('maksimalan_broj_igraca', '<=', $maxBrojIgraca);
    }

    
    $sobe = $query->paginate(2, ['*'], 'page', $page);

    return response()->json(['sobe' => $sobe], 200);
        /*
         $status = $request->input('status');
         $validneStatusVrednosti = ['aktivna', 'neaktivna', 'zavrsena'];
         if (!in_array($status, $validneStatusVrednosti)) {
             return response()->json(['error' => 'Nije vazeca vrednost za status.'], 400);
         }
         $sobe = Soba::where('status', $status)->get();    
         return response()->json(['sobe' => $sobe], 200);
         */
        }

    public function prikaziSobePoMaksimalnomBrojuUcesnika($maksimalanBrojUcesnika)
    {
        $sobe = Soba::where('maksimalan_broj_igraca', $maksimalanBrojUcesnika)->get();

        $formattedSobe = SobaResource::collection($sobe);

        return response()->json(['sobe' => $formattedSobe], 200);
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
        $validator = Validator::make($request->all(), [
            'kod_sobe' => 'required|string|size:6|unique:sobas',
            'maksimalan_broj_igraca' => 'required|integer|max:10',
            'status' => 'required|in:javna,privatna',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $soba = Soba::create([
            'kod_sobe' => $request->input('kod_sobe'),
            'maksimalan_broj_igraca' => $request->input('maksimalan_broj_igraca'),
            'status' => $request->input('status'),
        ]);

        return response()->json(['message' => 'Soba je napravljena uspesno', 'data' => $soba], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Soba $soba)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Soba $soba)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Soba $soba)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        {
            $soba = Soba::find($id);
            if (!$soba) {
                return response()->json(['error' => 'Soba nije pronadjena'], 404);
            }
    
            $soba->delete();
    
            return response()->json(['message' => 'Soba je uspesno obrisana']);
        }
    }
}
