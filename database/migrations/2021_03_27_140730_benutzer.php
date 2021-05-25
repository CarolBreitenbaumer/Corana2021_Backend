<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Benutzer extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('benutzer', function (Blueprint $table) {
            $table->id();
            $table ->string('benutzername')->unique();
            $table ->string( 'vorname' );
            $table ->string( 'nachname' );
            $table ->string( 'plz' );
            $table ->string( 'ort' );
            $table ->string( 'strasse' );
            $table ->string( 'hausnummer' );
            $table->string('passwort');
            $table->boolean('isAdmin');
            $table->string('email');
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
        Schema::dropIfExists('benutzer');
    }
}
