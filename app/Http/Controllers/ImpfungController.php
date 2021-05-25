<?php

namespace App\Http\Controllers;

use App\Models\Impfung;
use Illuminate\Http\Request;
use App\Models\Impfort;
use App\Models\Benutzer;
use App\Models\Angem_Person;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Auth;



class ImpfungController extends Controller
{
    public function index() { // public
        // man schickt Benutzer, angem_Person und Impfort gleich mit
        // man greift in angemeldetet Person auf Benutzer zu
        if(Auth::user() !=null && Auth::user()->isAdmin) {
            return Impfung::with(['angem_person', 'angem_person.benutzer', 'impfort'])->orderByDesc("impfdatum")->orderByDesc("impfzeit")->get();
        }else{
            return Impfung::with(['impfort'])->get();
        }
    }


    public function getUserVaccinationInfo(){ // logged in
        $userId = Auth::user()->id;
        $ang_Person = Angem_Person::with('impfung.impfort')->where ('benutzer_id',$userId)->first();
        if(is_null($ang_Person->impfung)){ // nicht angemeldet
            return null;
        }
        return $ang_Person->impfung;
    }

    public function freieTermine(){ // public
        $nowDate = Carbon::now();
        // Termin am selben Tag nicht möglich!!!
        return Impfung::withCount("angem_Person")
            ->groupBy("id")
            ->havingRaw('angem__person_count < maxteilnehmer')
            ->whereDate('impfdatum','>',$nowDate)
            -> with(['angem_person', 'angem_person.benutzer','impfort'])->get();
    }

    /**
     * find impfung by given id
     */
    public function findImpfungById (string $impfid):Impfung{
        if(Auth::user() && Auth::user()->isAdmin) {
            return Impfung::where('id', $impfid)
                ->with(['angem_person', 'angem_person.benutzer', 'impfort'])
                ->first();
        }else{
            return Impfung::where('id', $impfid)
                ->with(['impfort'])
                ->first();
        }
    }

    public function getImpfOrte(){ // public
        return Impfort::orderBy("ort")->get();
    }

    public function setUserVaccination($benutzerId){ // admin
        $user = Angem_Person::where ('benutzer_id',$benutzerId)->first();
        $user->impfungverabreicht = true;
        $user->save();
    }

    public function registerUserVaccination($impfungId){ // logged in
        DB::beginTransaction ();
        try {
            $impfung = Impfung::where('id', $impfungId)->first();
            $amountOfAlreadyRegistered = Angem_Person::where('impfung_id','=',$impfungId)->count();
            if($amountOfAlreadyRegistered >= $impfung->maxteilnehmer){
                return response()->json (null,406);
            }

            // Überprüfen, ob Benutzer bereits registriert ist?
            $userId = Auth::user()->id;
            // Angem_Person mit Impfung laden
            $ang_Person = Angem_Person::with('impfung')->where ('benutzer_id',$userId)->first();
            if(!is_null($ang_Person->impfung)){ // bereits angemeldet => fehler
                return response()->json (null,409);
            }

            $ang_Person->impfung()->associate($impfung)->save();
            DB::commit();
        }
        catch (\Exception $e ) {
            //rollback all queries
            DB:: rollBack ();
            return response()->json( "Das Speichern hat nicht funktioniert. Fehlermeldung:" . $e ->getMessage(), 420 );
        }
    }

    public function save(Request $request ) : JsonResponse { // admin
        $request = $this ->parseRequest( $request );

        if($request->maxteilnehmer <= 0){
            return response()->json( "Max. Teilnehmer muss > 0 sein " , 420 );
        }

        /*
        * use a transaction for saving model including relations
        * if one query fails, complete SQL statements will be rolled back
        */
        DB:: beginTransaction ();
        try {
            //Impfung muss nur in der DB angelegt werden
            $impfung = Impfung::create( $request ->all());

            //benötigen einen Impfort, Datensatz laden
            $impfort = Impfort::where('id',$request['impfort_id'])->first();

            // setzen des Datensatzes mit der Methode impfort() aus dem Model (Beziehung)
            // associate wird bei einer belongsTo Beziehung verwendet
            //bei hasMany wird save verwendet
            $impfung ->impfort()->associate($impfort);

            //mit commit wird transaktion durchgeführt
            DB:: commit ();
            // return a vaild http response - hier passt alles und das neu
            // angelegte Impfung wird ausgegeben
            return response()->json( $impfung ,201);
        }
            //try catch um kontrollierte Fehlerbehandlung zu haben
        catch (\Exception $e ) {
            //rollback all queries
            DB:: rollBack ();
            return response()->json( "das speichern der Impfung hat nicht funktioniert: " . $e ->getMessage(), 420 );
        }
    }
    /**
     * modify / convert values if needed
     * um das Datum in ein sql Datum zu implementieren
     */
    private function parseRequest ( Request $request ) : Request {
        // get date and convert it - its in ISO 8601, e.g. "2018-01-01T23:00:00.000Z"
        //$date = new \DateTime ( $request -> published );
        //$request [ 'published' ] = $date;
        return $request;
    }


    public function update(Request $request , string $id ) : JsonResponse // admin
    {
        DB:: beginTransaction();
        try {
            $impfung = Impfung:: with(['angem_person', 'angem_person.benutzer','impfort'])->where('id', $id)->first();
            if ($impfung != null) {
                $request = $this->parseRequest($request);
                // alle Daten werden gesetzt
                $impfung->update($request->all());

                // Referenzen werden gesetzt
                //benötigen einen Impfort, Datensatz laden
                $impfort = Impfort::where('id',$request['impfort_id'])->first();

                // setzen des Datensatzes mit der Methode impfort() aus dem Model (Beziehung)
                // associate wird bei einer belongsTo Beziehung verwendet
                //bei hasMany wird save verwendet
                $impfung ->impfort()->associate($impfort);
                $impfung->save();
            }
            DB:: commit();
            $impfung1 = Impfung:: with(['impfort'])
                ->where('id',$id)->first();
            // return a vaild http response
            return response()->json($impfung1, 201);
        } catch (\Exception $e) {
            // rollback all queries
            DB:: rollBack();
            return response()->json("update funktioniert nicht: " . $e->getMessage(), 420);
        }
    }

    /**
     * returns 200 if impfung deleted successfully , throws excpetion if not
     */
    public function delete (string $id): JsonResponse // admin
    {
        // can only be deleted successfully, if amount of registered persons is 0
        $impfung = Impfung::where ('id', $id)-> first ();
        $amountOfAlreadyRegistered = Angem_Person::where('impfung_id','=',$id)->count();
        if($amountOfAlreadyRegistered > 0){
            return response()->json (null,406);
        }

        if ( $impfung != null ) {
            $impfung->delete();
        }
        else
            throw new \Exception ( "impfung konnte nicht gelöscht werden - sie ist nicht vorhanden" );
        return response ()-> json ( 'impfung (' . $id . ') konnte erfolgreich gelöscht werden' , 200 );
    }
}
