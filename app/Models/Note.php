<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Note extends Model
{
    protected $fillable = [
        'valeur',
        'coefficient',
        'type_note', // DS, Devoir, Composition, etc.
        'date_evaluation',
        'appreciation',
        'eleve_id',
        'matiere_id',
        'classe_id',
        'professeur_id',
        'est_publie'
    ];

    protected $casts = [
        'valeur' => 'float',
        'coefficient' => 'integer',
        'date_evaluation' => 'date',
        'est_publie' => 'boolean'
    ];

    public function eleve(): BelongsTo
    {
        return $this->belongsTo(Eleve::class);
    }

    public function matiere(): BelongsTo
    {
        return $this->belongsTo(Matiere::class);
    }

    public function classe(): BelongsTo
    {
        return $this->belongsTo(Classe::class);
    }

    public function professeur(): BelongsTo
    {
        return $this->belongsTo(Professeur::class);
    }

    // Calcul de la note pondérée
    public function getNotePondereeAttribute(): float
    {
        return $this->valeur * $this->coefficient;
    }

    // Vérifie si la note est éliminatoire (en dessous de la moyenne)
    public function estEliminatoire(float $noteEliminatoire = 5.0): bool
    {
        return $this->valeur < $noteEliminatoire;
    }
}
