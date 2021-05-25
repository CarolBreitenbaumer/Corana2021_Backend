<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Benutzer;

class BenutzerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // hier müssen alle Attribute angegeben werden
        $benutzer1 = new Benutzer();
        $benutzer1->benutzername = 'carolhuber';
        $benutzer1->vorname = 'Carol';
        $benutzer1->nachname = 'Huber';
        $benutzer1->plz = '4055';
        $benutzer1->ort = 'Pucking';
        $benutzer1->strasse = 'Hasenuferstraße';
        $benutzer1->hausnummer = '12';
        $benutzer1->passwort = bcrypt('carol123');
        $benutzer1->isAdmin = false;
        $benutzer1->email = 'carol97@gmx.at';
        $benutzer1->save();

        $benutzer2 = new Benutzer();
        $benutzer2->benutzername = 'leoniemayer';
        $benutzer2->vorname = 'Leonie';
        $benutzer2->nachname = 'Mayer';
        $benutzer2->plz = '4020';
        $benutzer2->ort = 'Linz';
        $benutzer2->strasse = 'Linzerstraße';
        $benutzer2->hausnummer = '5';
        $benutzer2->passwort = bcrypt('leonie123');
        $benutzer2->isAdmin = true;
        $benutzer2->email = 'leonie74@gmx.at';
        $benutzer2->save();

        $benutzer3 = new Benutzer();
        $benutzer3->benutzername = 'sarahuber';
        $benutzer3->vorname = 'Sara';
        $benutzer3->nachname = 'Huber';
        $benutzer3->plz = '4020';
        $benutzer3->ort = 'Linz';
        $benutzer3->strasse = 'Grazerstraße';
        $benutzer3->hausnummer = '45';
        $benutzer3->passwort = bcrypt('sara123');
        $benutzer3->isAdmin = true;
        $benutzer3->email = 'sara74@gmx.at';
        $benutzer3->save();


        $benutzer4 = new Benutzer();
        $benutzer4->benutzername = 'tinatim';
        $benutzer4->vorname = 'Tina';
        $benutzer4->nachname = 'Tim';
        $benutzer4->plz = '4020';
        $benutzer4->ort = 'Linz';
        $benutzer4->strasse = 'Donaustraße';
        $benutzer4->hausnummer = '19';
        $benutzer4->passwort = bcrypt('tina123');
        $benutzer4->isAdmin = false;
        $benutzer4->email = 'tina@gmx.at';
        $benutzer4->save();

        /*
        $user = new Benutzer();
        $user->benutzername = 'testuser';
        $user->email = 'test@gmail.com';
        $user->passwort = bcrypt('secret');

        $user->save();*/

    }
}
