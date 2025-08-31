<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Classe extends Model
{
    protected $fillable = [
        'nom',
        'niveau',
        'annee_scolaire',
        'professeur_principal_id',
        'salle',
        'effectif_max'
    ];

    public function professeurPrincipal(): BelongsTo
    {
        return $this->belongsTo(Professeur::class, 'professeur_principal_id');
    }

    public function eleves(): HasMany
    {
        return $this->hasMany(Eleve::class);
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

    // Méthode pour obtenir le libellé complet de la classe (ex: "6ème A - Année 2023/2024")
    public function getLibelleCompletAttribute(): string
    {
        return "{$this->niveau} {$this->nom} - Année {$this->annee_scolaire}";
    }
}
