<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

/* auth */
Route::post('auth/login', [\App\Http\Controllers\AuthController::class, 'login']);

Route::get('vaccinationAppointment', [\App\Http\Controllers\ImpfungController::class,'index']);
Route::get('vaccinationAppointment/byId/{impfid}',[\App\Http\Controllers\ImpfungController::class,'findImpfungById']);
Route::get('vaccinationAppointment/free',[\App\Http\Controllers\ImpfungController::class,'freieTermine']);
Route::get('vaccinationLocation',[\App\Http\Controllers\ImpfungController::class,'getImpfOrte']);

// methods with authentication needed
Route::group(['middleware' => ['api', 'auth.jwt']], function() {
    /* save impfung uses VERB post */
    Route::post('auth/logout', [App\Http\Controllers\AuthController::class, 'logout']);
    Route::post('user/registerVaccinationAppointment/{impfungId}',[\App\Http\Controllers\ImpfungController::class,'registerUserVaccination']);
    Route::get('user/vaccinationAppointment',[\App\Http\Controllers\ImpfungController::class,'getUserVaccinationInfo']);
});

Route::group(['middleware' => ['api', 'auth.jwt','isAdmin']], function() {
    // serverseitige Validierung, ob der Benutzer ein Administrator ist
    Route::post('user/setVaccinated/{benutzerId}',[\App\Http\Controllers\ImpfungController::class,'setUserVaccination']); // user/setVaccinated
    Route::post('vaccinationAppointment', [\App\Http\Controllers\ImpfungController::class,'save']);
    Route::put('vaccinationAppointment/{impfid}', [\App\Http\Controllers\ImpfungController::class,'update']); // vaccinationAppointment
    Route::delete('vaccinationAppointment/{impfid}', [\App\Http\Controllers\ImpfungController::class,'delete']); // vaccinationAppointment
});

