<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Horaire extends Model
{

    protected $fillable = ['debut', 'fin'];

    
    public function reservations()
    {
        return $this->belongsToMany(Reservation::class, 'horaire_reservation');
    }
}
