<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Equipement extends Model
{
    protected $fillable = ['nom', 'description', 'statut'];

    // un équipement peut appartenir à plusieurs laboratoires
    public function laboratoires()
    {
        return $this->belongsToMany(Laboratoire::class, 'equipement_laboratoire');
    }
}
