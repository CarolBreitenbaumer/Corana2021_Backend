<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;


class Benutzer extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    // weil ich die Tabellen deutsch benannt habe und Laravel die
    // Namenskonvention nur englisch macht, muss es hier explizit angegeben werden
    protected $table= "benutzer";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'benutzername', 'vorname', 'nachname',
        'plz', 'ort', 'strasse', 'hausnummer',
        'passwort', 'isAdmin', 'email',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'passwort', 'remember_token',
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
     * benutzer has one angem_Person (1:1)
     */
    //man muss "gegeüberliegende" Klasse angeben
    public function angem_Person() : HasOne {
        return $this->hasOne(Angem_Person::class);
    }

    public function getJWTIdentifier() {
        return $this->getKey();
    }

    public function getJWTCustomClaims() {
        return ['user' => ['id' => $this->id, 'isAdmin' => $this->isAdmin]];
        // id & isAdmin wird für die Sitzung gespeichert
    }

    public function getAuthPassword() {
        // AuthController: beim login ruft auth().attempt(...) diese funktion auf, um das passwort aus der db abzufragen
        return $this->passwort;
    }
}
