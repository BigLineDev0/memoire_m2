<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = ['user_id','laboratoire_id','date','objectif','statut'];

    protected function date(): \Illuminate\Database\Eloquent\Casts\Attribute
    {
        return new \Illuminate\Database\Eloquent\Casts\Attribute(
            get: fn($value) => \Carbon\Carbon::parse($value),
            set: fn($value) => \Carbon\Carbon::parse($value)->format('Y-m-d'),
        );
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function laboratoire()
    {
        return $this->belongsTo(Laboratoire::class);
    }

    public function horaires()
    {
        return $this->belongsToMany(Horaire::class, 'horaire_reservation');
    }

    public function equipements()
    {
        return $this->belongsToMany(Equipement::class, 'equipement_reservation');
    }
}
