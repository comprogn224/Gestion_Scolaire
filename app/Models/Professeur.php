<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Professeur extends Model
{
    protected $fillable = [
        'nom',
        'prenom',
        'date_naissance',
        'sexe',
        'adresse',
        'telephone',
        'email',
        'specialite',
        'date_embauche',
        'photo'
    ];

    protected $dates = ['date_naissance', 'date_embauche'];

    public function classes(): HasMany
    {
        return $this->hasMany(Classe::class);
    }

    public function matieres(): HasMany
    {
        return $this->hasMany(Matiere::class);
    }

    public function notes(): HasMany
    {
        return $this->hasMany(Note::class);
    }

    public function absences(): HasMany
    {
        return $this->hasMany(Absence::class);
    }

    public function getNomCompletAttribute(): string
    {
        return "{$this->prenom} {$this->nom}";
    }
}
