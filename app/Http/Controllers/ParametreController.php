<?php

namespace App\Http\Controllers;

use App\Models\Parametre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ParametreController extends Controller
{
    /**
     * Affiche la page des paramètres
     */
    public function index()
    {
        $parametres = Parametre::all()->pluck('valeur', 'cle')->toArray();
        return view('parametres.index', compact('parametres'));
    }

    /**
     * Met à jour les paramètres
     */
    public function update(Request $request)
    {
        $parametres = $request->except('_token');
        
        $regles = [
            'nom_etablissement' => 'required|string|max:255',
            'adresse_etablissement' => 'required|string|max:255',
            'telephone_etablissement' => 'required|string|max:20',
            'email_etablissement' => 'required|email|max:255',
            'directeur_etablissement' => 'required|string|max:255',
            'annee_scolaire' => 'required|regex:/^\d{4}-\d{4}$/',
            'date_rentree' => 'required|date',
            'date_fin_annee' => 'required|date|after:date_rentree',
            'seuil_absence_alerte' => 'required|integer|min:1',
            'note_minimale' => 'required|numeric|min:0|max:20',
            'note_maximale' => 'required|numeric|min:0|max:20|gt:note_minimale',
        ];
        
        $messages = [
            'annee_scolaire.regex' => 'Le format de l\'année scolaire doit être AAAA-AAAA',
            'date_fin_annee.after' => 'La date de fin d\'année doit être postérieure à la date de rentrée',
            'note_maximale.gt' => 'La note maximale doit être supérieure à la note minimale',
        ];
        
        $validated = $request->validate($regles, $messages);
        
        foreach ($validated as $cle => $valeur) {
            Parametre::updateOrCreate(
                ['cle' => $cle],
                ['valeur' => $valeur]
            );
        }
        
        return redirect()->route('parametres.index')
                        ->with('success', 'Paramètres mis à jour avec succès.');
    }
}
