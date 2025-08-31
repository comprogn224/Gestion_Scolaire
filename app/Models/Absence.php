<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Absence extends Model
{
    protected $fillable = [
        'eleve_id',
        'matiere_id',
        'date',
    ];

    public function eleve()
    {
        return $this->belongsTo(Eleve::class);
    }

    public function matiere()
    {
        return $this->belongsTo(Matiere::class);
    }
}
