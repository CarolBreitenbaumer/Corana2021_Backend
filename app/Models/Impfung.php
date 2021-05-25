<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Impfung extends Model
{
    use HasFactory;

    // weil ich die Tabellen deutsch benannt habe und Laravel die
    // Namenskonvention nur englisch macht, muss es hier explizit angegeben werden
    protected $table= "impfung";

    protected $fillable = [
        'impfzeit', 'impfdatum', 'maxteilnehmer',
        'impfort_id'];

    public function scopeMaxTeilnehmer($query){ //Task::incomplete
        return $query->where('maxteilnehmer','>=',10);
    }

    /**
     * impfungen has Many angem_Personen (1:n)
     */
    //man muss "gegeüberliegende" Klasse angeben
    public function angem_Person() : HasMany {
        return $this->hasMany(Angem_Person::class);
    }

    /**
     * impfungen belongs to impfort (n:1)
     */
    //man muss "gegeüberliegende" Klasse angeben
    public function impfort() : BelongsTo
    {
        return $this->belongsTo(Impfort::class);
    }
}

