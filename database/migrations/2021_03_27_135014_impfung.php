<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Impfung extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('impfung',function(Blueprint $table) {
            $table ->id();
            // impfung_id is unique
            $table ->time( 'impfzeit' );
            // nur das nullable setzen, was nicht angegeben werden muss
            $table ->date( 'impfdatum' );
            $table ->integer( 'maxteilnehmer' )->default(1);
            // fk fields for relations - model name lowercase + "_id"
            $table ->bigInteger ( 'impfort_id' )-> unsigned ();
            // create constraint in DB
            $table ->time('dauer')->default("00:15:00");
            $table -> foreign ( 'impfort_id')
                -> references ( 'id' )-> on ( 'impfort')
                -> onDelete ( 'cascade' );
            $table ->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('impfung');
    }
}
