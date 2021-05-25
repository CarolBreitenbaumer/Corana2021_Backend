<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AngemPerson extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('angem_person', function (Blueprint $table) {
            $table->id();
            // Daten müssen angegeben werden,
            // wenn sie nicht angegeben werden müssen sind sie nullable
            $table ->string( 'geschlecht' );
            $table ->date( 'gbdatum' );
            //SV NR ist einzigartig
            $table ->bigInteger( 'svnr' )->unique();
            $table ->boolean( 'impfungverabreicht' );
            // fk fields for relations - model name lowercase + "_id"
            $table ->bigInteger ( 'impfung_id' )-> unsigned ()->nullable();
            // create constraint in DB
            $table -> foreign ( 'impfung_id')
                -> references ( 'id' )-> on ( 'impfung')
                -> onDelete ( 'cascade' );
            // fk fields for relations - model name lowercase + "_id"
            $table ->bigInteger ( 'benutzer_id' )-> unsigned ();
            // create constraint in DB
            $table -> foreign ( 'benutzer_id')
                -> references ( 'id' )-> on ( 'benutzer')
                -> onDelete ( 'cascade' );
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('angem_person');
    }
}
