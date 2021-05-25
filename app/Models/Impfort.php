<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Impfort extends Model
{
    use HasFactory;

    // weil ich die Tabellen deutsch benannt habe und Laravel die
    // Namenskonvention nur englisch macht, muss es hier explizit angegeben werden
    protected $table= "impfort";


    protected $fillable = [
        'plz', 'ort', 'strasse', 'hausnummer', 'bezeichnung'
    ];


    /**
     * impfort has many impfungen (1:n)
     */
    //man muss "gegeüberliegende" Klasse angeben
    public function impfungen():HasMany {
        return $this->hasMany(Impfung::class);
    }
}
