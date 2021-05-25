<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Angem_Person extends Authenticatable
{
    use HasFactory, Notifiable;


    // weil ich die Tabellen deutsch benannt habe und Laravel die
    // Namenskonvention nur englisch macht, muss es hier explizit angegeben werden
    protected $table= "angem_person";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'geschlecht',
        'gbdatum', 'svnr',
        'impfungverabreicht', 'impfung_id',
        'benutzer_id'
        ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * angem_Person belongs to impfungen (1:n)
     */
    //man muss "gegeüberliegende" Klasse angeben
    public function impfung() : BelongsTo {
        return $this->belongsTo(Impfung::class);
    }

    /**
     * angem_Person belongs to benutzer (1:1)
     */
    //man muss "gegeüberliegende" Klasse angeben
    // hier belongs to, damit man den Benutzer im Seeder setzen kann
    public function benutzer() : BelongsTo {
        return $this->belongsTo(Benutzer::class);
    }



}
