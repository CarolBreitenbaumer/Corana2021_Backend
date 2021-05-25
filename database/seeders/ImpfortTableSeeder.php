<?php

namespace Database\Seeders;


use App\Models\Impfort;
use Illuminate\Database\Seeder ;


class ImpfortTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        

        $ort1 = new Impfort();
        $ort1->plz = '4055';
        $ort1->ort = 'Pucking';
        $ort1->strasse = 'Hasenuferstraße';
        $ort1->hausnummer = '74';
        $ort1->bezeichnung = 'Das ist die erste Straße entlang der Hauptstraße Richtung  Hasenufer.';
        $ort1->save();

        $ort1 = new Impfort();
        $ort1->plz = '4020';
        $ort1->ort = 'Linz';
        $ort1->strasse = 'Linzerstraße';
        $ort1->hausnummer = '2';
        $ort1->bezeichnung = 'Hier gibt es viele Einkaufsmöglichkeiten.';
        $ort1->save();


    }
}
