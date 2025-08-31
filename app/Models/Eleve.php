<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Eleve extends Model
{
    protected $fillable = [
        'nom',
        'prenom',
        'date_naissance',
        'sexe',
        'adresse',
        'telephone',
        'email',
        'classe_id',
        'photo',
        'date_inscription'
    ];

    protected $dates = ['date_naissance', 'date_inscription'];

    public function classe(): BelongsTo
    {
        return $this->belongsTo(Classe::class);
    }

    public function notes(): HasMany
    {
        return $this->hasMany(Note::class);
    }

    public function absences(): HasMany
    {
        return $this->hasMany(Absence::class);
    }

    // Méthode pour obtenir le nom complet
    public function getNomCompletAttribute(): string
    {
        return "{$this->prenom} {$this->nom}";
    }
}
