<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Impfort extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('impfort', function (Blueprint $table) {
            $table->id();
            // Annahme: plz is unique
            $table->string('plz')->unique();
            $table->string('ort');
            $table->string('strasse');
            $table->string('hausnummer');
            $table->text('bezeichnung');
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
        Schema::dropIfExists('impfort');
    }
}
