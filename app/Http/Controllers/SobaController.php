<?php

namespace App\Http\Controllers;

use App\Models\Soba;
use Illuminate\Http\Request;
use App\Http\Resources\SobaResource;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Validator; 
use App\Models\UserProgress;

class SobaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    
    public function getUsersProgress($roomName)
    {
        try {
            $progress = UserProgress::where('room_name', $roomName)
                ->select('username', 'question_number')
                ->get();
     
            return response()->json($progress, 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error fetching users progress', 'error' => $e->getMessage()], 500);
        }
    }
     

    public function updateQuestionProgress(Request $request)
    {
        $roomName = $request->input('room');
        $username = $request->input('username');
        $questionNumber = $request->input('questionNumber');

        // Emituj događaj
        event(new QuestionProgressUpdated($roomName, $username, $questionNumber));

        return response()->json(['message' => 'Event emitted'], 200);
    }


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
            'naziv_sobe' => 'required|string|max:255',
            'pitanja.*.pitanje' => 'required|string|max:255',
            'pitanja.*.odgovori.*' => 'required|string|max:255',
            'pitanja.*.tacan_odgovor' => 'required|integer|min:0|max:3',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }
    
        $soba = Soba::create([
            'kod_sobe' => $request->input('kod_sobe'),
            'maksimalan_broj_igraca' => $request->input('maksimalan_broj_igraca'),
            'status' => $request->input('status'),
            'naziv_sobe' => $request->input('naziv_sobe')
        ]);
    
        // Dodavanje pitanja i odgovora za sobu
        foreach ($request->input('pitanja') as $pitanjeData) {
            $pitanje = $soba->pitanja()->create([
                'tekst_pitanja' => $pitanjeData['pitanje'],
                'kod_sobe' => $soba->kod_sobe // Dodajemo kod sobe pitanju
            ]);
    
            foreach ($pitanjeData['odgovori'] as $index => $odgovorData) {
                $pitanje->odgovori()->create([
                    'tekst_odgovora' => $odgovorData,
                    'tacan_odgovor' => $index == $pitanjeData['tacan_odgovor']
                ]);
            }
        }
    
        return response()->json(['message' => 'Soba je napravljena uspešno', 'data' => $soba], 201);
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

public function vratiRandomSobu(Request $request)
{
    // Dohvati slučajnu sobu sa pitanjima i odgovorima
    $randomSoba = Soba::with('pitanja.odgovori')->inRandomOrder()->first();

    // Pripremi podatke za odgovor
    $sobaData = [
        'soba' => $randomSoba,
        'pitanja' => $randomSoba->pitanja->map(function ($pitanje) {
            return [
                'tekst_pitanja' => $pitanje->tekst_pitanja,
                'odgovori' => $pitanje->odgovori->pluck('tekst_odgovora')->toArray(),
                'tacan_odgovor' => $pitanje->odgovori->firstWhere('tacan_odgovor', 1)->tekst_odgovora,
            ];
        }),
    ];

    // Vrati podatke kao JSON odgovor
    return response()->json($sobaData, 200);
}
public function getSpecificQuiz($sobaCode)
{
    $soba = Soba::where('naziv_sobe', $sobaCode)->first();


    
    if (!$soba) {
        return response()->json(['error' => 'Soba not found'], 404);
    }

    // Ako soba postoji, vraćamo pitanja za taj kviz
    $sobaData = [
        'soba' => $soba,
        'pitanja' => $soba->pitanja->map(function ($pitanje) {
            return [
                'tekst_pitanja' => $pitanje->tekst_pitanja,
                'odgovori' => $pitanje->odgovori->pluck('tekst_odgovora')->toArray(),
                'tacan_odgovor' => $pitanje->odgovori->firstWhere('tacan_odgovor', 1)->tekst_odgovora,
            ];
        }),
    ];
    return response()->json($sobaData, 200);
}
public function getQuizFromCode($kod)
{
    $soba = Soba::where('kod_sobe', $kod)->first();


    
    if (!$soba) {
        return response()->json(['error' => 'Soba not found'], 404);
    }

    // Ako soba postoji, vraćamo pitanja za taj kviz
    $sobaData = [
        'soba' => $soba,
        'pitanja' => $soba->pitanja->map(function ($pitanje) {
            return [
                'tekst_pitanja' => $pitanje->tekst_pitanja,
                'odgovori' => $pitanje->odgovori->pluck('tekst_odgovora')->toArray(),
                'tacan_odgovor' => $pitanje->odgovori->firstWhere('tacan_odgovor', 1)->tekst_odgovora,
            ];
        }),
    ];
    return response()->json($sobaData, 200);
}


}
