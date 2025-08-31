<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Matiere extends Model
{
    protected $fillable = [
        'nom',
        'code',
        'coefficient',
        'description',
        'classe_id',
        'professeur_id',
        'couleur'
    ];

    public function professeur(): BelongsTo
    {
        return $this->belongsTo(Professeur::class);
    }

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

    // Méthode pour obtenir le libellé complet de la matière (ex: "Mathématiques (Coef. 3)")
    public function getLibelleCompletAttribute(): string
    {
        return "{$this->nom} (Coef. {$this->coefficient})";
    }
}
