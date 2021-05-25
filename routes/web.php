<?php

use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*
// ----------- Ausgabe der Impfungn aus der DB--------
Route:: get ( '/' , function () {
    $books = DB:: table ( 'impfung' )->get();
    //return $inpfungen ;
    return view( 'impfungen.index' , compact ( 'impfungen' ));});
*/

/*
Route::get('/', function () {
    $impfung=DB::table('impfung')->get();
    return $impfung;
    //return view('welcome',compact('impfung'));
});


// ----------- Ausgabe der Bücher aus der DB--------
Route:: get ( '/' , function () {
    $impfungen = DB::table('impfung')->get();
    //return $books ;
// ------------ zweite Route, mit IDs,
return view( 'impfungen.index' , compact ( 'impfungen' ));});

// es wird nun in .../book/1 das Buch mit der ID 1 ausgegeben -----------------
Route :: get ( '/impfung/{id}' , function ( $id ) {
    //dd($isbn); //die and dump -> Hilfsfunktion von Laravel
    $impfung = DB::table('impfung')->find($id );
    //dd ( $impfung );
    return view( 'impfungen.show' , compact ( 'impfung' ));
});

Route::get('/impfungen', function () {
    //$impfungen = DB::table('$impfung')->get();
    $impfungen = Impfung::all();
    return view( 'impfungen.index' ,compact ( 'impfung' ));
});
Route::get('/impfungen/{id}', function ( $id ) {
    //dd($isbn); //die and dump -> Hilfsfunktion von Laravel
    $impfung=Impfung::find($id);
    //dd($impfung);
    return view('impfungen.show',compact('impfung' ));
});

*/

/*


Route::get('/', function () {
    $angemperson=DB::table('angem_person')->get();
    return $angemperson;
    //return view('welcome');
});



Route::get('/', function () {
    $impfort=DB::table('impfort')->get();
    return view( 'welcome' , compact ( 'impfort' ));;
    //return view('welcome');
});

*/



Route::get('/', [\App\Http\Controllers\ImpfungController::class,'index']);
Route::get('/impfung', [\App\Http\Controllers\ImpfungController::class,'index']);
Route::get('/impfung/{impfung}', [\App\Http\Controllers\ImpfungController::class,'show']);
