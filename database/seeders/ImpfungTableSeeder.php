<?php

namespace Database\Seeders;

use App\Models\Impfung;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use DateTime;
use function Sodium\add;


class ImpfungTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // hier müssen alle Attribute angegeben werden
        $impfung1 = new Impfung();
        $impfung1->impfzeit = new DateTime();
        $impfung1->impfdatum = (new DateTime("2021-07-08"));
        $impfung1->maxteilnehmer = '12';

        $impfung2 = new Impfung();
        $impfung2->impfzeit = new DateTime();
        $impfung2->impfdatum = (new DateTime("2021-06-12"));
        $impfung2->maxteilnehmer = '9';

        // first user
        $impfort = \App\Models\Impfort::all()->first();
        $impfung1->impfort()->associate($impfort);

        $impfung1->save();

        $impfung2->impfort()->associate($impfort);

        $impfung2->save();




    }
}
