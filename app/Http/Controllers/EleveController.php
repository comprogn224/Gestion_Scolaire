<?php

namespace App\Http\Controllers;

use App\Models\Eleve;
use App\Models\Classe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class EleveController extends Controller
{
    /**
     * Affiche la liste des élèves
     */
    public function index()
    {
        $eleves = Eleve::with(['classe', 'notes', 'absences'])
                      ->orderBy('nom')
                      ->paginate(15);
        
        return view('eleve.index', compact('eleves'));
    }

    /**
     * Affiche le formulaire de création d'un élève
     */
    public function create()
    {
        $classes = Classe::orderBy('nom')->get();
        return view('eleve.create', compact('classes'));
    }

    /**
     * Enregistre un nouvel élève
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:50',
            'prenom' => 'required|string|max:50',
            'date_naissance' => 'required|date',
            'sexe' => 'required|in:Masculin,Féminin',
            'adresse' => 'required|string|max:255',
            'telephone' => 'nullable|string|max:20',
            'email' => 'nullable|email|unique:eleves,email',
            'classe_id' => 'required|exists:classes,id',
            'photo' => 'nullable|image|max:2048',
        ]);

        // Gestion du téléversement de la photo
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('eleves/photos', 'public');
            $validated['photo'] = $photoPath;
        }

        $eleve = Eleve::create($validated);

        return redirect()->route('eleves.show', $eleve->id)
                        ->with('success', 'Élève créé avec succès.');
    }

    /**
     * Affiche les détails d'un élève
     */
    public function show(Eleve $eleve)
    {
        $eleve->load(['classe', 'notes.matiere', 'absences.matiere']);
        
        // Calcul des moyennes
        $moyenneGenerale = $eleve->notes->avg('valeur');
        $notesParMatiere = $eleve->notes->groupBy('matiere.nom');
        
        return view('eleve.show', compact('eleve', 'moyenneGenerale', 'notesParMatiere'));
    }

    /**
     * Affiche le formulaire de modification d'un élève
     */
    public function edit(Eleve $eleve)
    {
        $classes = Classe::orderBy('nom')->get();
        return view('eleve.edit', compact('eleve', 'classes'));
    }

    /**
     * Met à jour les informations d'un élève
     */
    public function update(Request $request, Eleve $eleve)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:50',
            'prenom' => 'required|string|max:50',
            'date_naissance' => 'required|date',
            'sexe' => 'required|in:Masculin,Féminin',
            'adresse' => 'required|string|max:255',
            'telephone' => 'nullable|string|max:20',
            'email' => 'nullable|email|unique:eleves,email,' . $eleve->id,
            'classe_id' => 'required|exists:classes,id',
            'photo' => 'nullable|image|max:2048',
        ]);

        // Gestion du téléversement de la photo
        if ($request->hasFile('photo')) {
            // Supprimer l'ancienne photo si elle existe
            if ($eleve->photo) {
                Storage::disk('public')->delete($eleve->photo);
            }
            
            $photoPath = $request->file('photo')->store('eleves/photos', 'public');
            $validated['photo'] = $photoPath;
        }

        $eleve->update($validated);

        return redirect()->route('eleves.show', $eleve->id)
                        ->with('success', 'Élève mis à jour avec succès.');
    }

    /**
     * Supprime un élève
     */
    public function destroy(Eleve $eleve)
    {
        // Supprimer la photo si elle existe
        if ($eleve->photo) {
            Storage::disk('public')->delete($eleve->photo);
        }
        
        $eleve->delete();
        
        return redirect()->route('eleves.index')
                        ->with('success', 'Élève supprimé avec succès.');
    }
    
    /**
     * Affiche le bulletin de notes d'un élève
     */
    public function bulletin(Eleve $eleve)
    {
        $eleve->load(['classe', 'notes.matiere']);
        $notesParMatiere = $eleve->notes->groupBy('matiere.nom');
        
        return view('eleve.bulletin', compact('eleve', 'notesParMatiere'));
    }
    
    /**
     * Affiche l'historique des absences d'un élève
     */
    public function absences(Eleve $eleve)
    {
        $absences = $eleve->absences()
                         ->with('matiere')
                         ->orderBy('date', 'desc')
                         ->paginate(10);
        
        return view('eleve.absences', compact('eleve', 'absences'));
    }
}
