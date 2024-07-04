<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PitanjeController;
use App\Http\Controllers\OdgovorController;
use App\Http\Controllers\SobaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Events\QuestionProgressUpdated;
use Illuminate\Support\Facades\Log;
use App\Models\UserProgress;



/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
/*
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
*/



Route::get('/sobe', [SobaController::class, 'index']);
Route::get('/sobe/random', [SobaController::class, 'vratiRandomSobu']);
Route::get('/sobe/status', [SobaController::class, 'prikaziSobeNaOsnovuStatusa']); 
Route::get('/sobe/maksimalanbrojucesnika/{maksimalan_broj_ucesnika}', [SobaController::class, 'prikaziSobePoMaksimalnomBrojuUcesnika']);
Route::get('sobe/{sobaCode}/quiz',  [SobaController::class, 'getSpecificQuiz']);
Route::get('sobe2/{kod}/quiz',  [SobaController::class, 'getQuizFromCode']);
Route::get('/room/{nazivSobe}/progress', [SobaController::class, 'getUsersProgress']);



Route::post('/emitQuestionProgress', function (Request $request) {
    try {
        $roomName = $request->input('room');
        $username = $request->input('username');
        $questionNumber = $request->input('questionNumber');

        Log::info('Received input data', [
            'roomName' => $roomName,
            'username' => $username,
            'questionNumber' => $questionNumber
        ]);

        if (is_null($roomName) || is_null($username) || is_null($questionNumber)) {
            Log::error('Missing input data', [
                'roomName' => $roomName,
                'username' => $username,
                'questionNumber' => $questionNumber
            ]);
            return response()->json(['message' => 'Bad Request'], 400);
        }

        // Ažuriraj napredak korisnika
        UserProgress::updateOrCreate(
            ['username' => $username, 'room_name' => $roomName],
            ['question_number' => $questionNumber]
        );

        // Log pre emitovanja event-a
        Log::info('Emitting event', [
            'event' => 'QuestionProgressUpdated',
            'roomName' => $roomName,
            'username' => $username,
            'questionNumber' => $questionNumber
        ]);

        event(new QuestionProgressUpdated($roomName, $username, $questionNumber));

        // Log posle uspešnog emitovanja event-a
        Log::info('Event emitted successfully', [
            'event' => 'QuestionProgressUpdated',
            'roomName' => $roomName,
            'username' => $username,
            'questionNumber' => $questionNumber
        ]);

        return response()->json(['message' => 'Event emitted'], 200);
    } catch (\Exception $e) {
        Log::error('Error emitting QuestionProgressUpdated event: ' . $e->getMessage(), [
            'trace' => $e->getTraceAsString()
        ]);
        return response()->json(['message' => 'Internal Server Error', 'error' => $e->getMessage()], 500);
    }
});





Route::get('/room/{roomName}/progress', [SobaController::class, 'getUsersProgress']);


Route::post('/register',[AuthController::class,'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/forgotpassword',[AuthController::class,'forgotPassword']);
Route::post('/resetpassword',[AuthController::class,'resetPassword']);
Route::post('/rezultati',[RezultatController::class,'store']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/logout', [AuthController::class, 'logout']);  

    Route::get('/users', [UserController::class, 'index']);  

    Route::post('/sobe', [SobaController::class, 'store']);

    Route::get('/odgovori', [OdgovorController::class, 'index']);

    Route::delete('/sobe/{id}', [SobaController::class, 'destroy']);

    //Route::get('/pitanja', [PitanjeController::class, 'index']);
    //Route::put('/pitanja/{id}', [PitanjeController::class, 'update']);
    Route::resource('pitanja', PitanjeController::class);
    
    Route::put('/odgovori/{id}', [OdgovorController::class, 'update']);

});




