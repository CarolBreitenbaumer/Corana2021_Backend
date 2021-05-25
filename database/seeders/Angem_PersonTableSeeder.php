<?php

namespace Database\Seeders;

use App\Models\Angem_Person;
use App\Models\Benutzer;
use Illuminate\Database\Seeder;
use DateTime;

class Angem_PersonTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // hier müssen alle Attribute angegeben werden
        $ang_Person1 = new Angem_Person();

        // first user
        // referenz auf Benutzer
        $benutzer = \App\Models\Benutzer::all()->first();
        $ang_Person1->benutzer()->associate($benutzer);

        $ang_Person1->geschlecht = 'weiblich';
        $ang_Person1->gbdatum = '2000-02-09';
        $ang_Person1->svnr = '34728372897';
        $ang_Person1->impfungverabreicht = false;

        $ang_Person1->save();

        $ang_Person2 = new Angem_Person();

        // Methode, die im Model ist daher benutzer()
        // referenz auf Benutzer
        $ang_Person2->benutzer()->associate(Benutzer::all()->skip(3)->first());

        $ang_Person2->geschlecht = 'männlich';
        $ang_Person2->gbdatum = '1997-08-07';
        $ang_Person2->svnr = '28838298333';
        $ang_Person2->impfungverabreicht = false;

        $ang_Person2->save();

    }
}
