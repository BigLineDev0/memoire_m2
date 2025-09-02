<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laboratoire extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'nom',
        'description',
        'localisation',
        'photo',
        'statut',
    ];

    // un laboratoire peut avoir plusieurs équipements
    public function equipements()
    {
        return $this->belongsToMany(Equipement::class, 'equipement_laboratoire');
    }

}
