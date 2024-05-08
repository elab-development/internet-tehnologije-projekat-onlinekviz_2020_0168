<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PitanjeController;
use App\Http\Controllers\OdgovorController;
use App\Http\Controllers\SobaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;

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




