<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Maintenance extends Model
{
    protected $fillable = [
        'user_id',
        'equipement_id',
        'description',
        'date_prevue',
        'statut',
    ];

    protected $casts = [
        'date_prevue' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function equipement()
    {
        return $this->belongsTo(Equipement::class);
    }
}
