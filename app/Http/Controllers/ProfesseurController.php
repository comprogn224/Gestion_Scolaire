<?php

namespace App\Http\Controllers;

use App\Models\Professeur;
use App\Models\Classe;
use App\Models\Matiere;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfesseurController extends Controller
{
    /**
     * Affiche la liste des professeurs
     */
    public function index()
    {
        $professeurs = Professeur::with(['classes', 'matieres'])
                               ->orderBy('nom')
                               ->paginate(15);
        
        return view('professeurs.index', compact('professeurs'));
    }

    /**
     * Affiche le formulaire de création d'un professeur
     */
    public function create()
    {
        $classes = Classe::orderBy('nom')->get();
        $matieres = Matiere::orderBy('nom')->get();
        return view('professeurs.create', compact('classes', 'matieres'));
    }

    /**
     * Enregistre un nouveau professeur
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:50',
            'prenom' => 'required|string|max:50',
            'date_naissance' => 'required|date',
            'sexe' => 'required|in:Masculin,Féminin',
            'adresse' => 'required|string|max:255',
            'telephone' => 'required|string|max:20',
            'email' => 'required|email|unique:professeurs,email',
            'specialite' => 'required|string|max:100',
            'date_embauche' => 'required|date',
            'photo' => 'nullable|image|max:2048',
            'classes' => 'nullable|array',
            'classes.*' => 'exists:classes,id',
            'matieres' => 'nullable|array',
            'matieres.*' => 'exists:matieres,id',
        ]);

        // Gestion du téléversement de la photo
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('professeurs/photos', 'public');
            $validated['photo'] = $photoPath;
        }

        $professeur = Professeur::create($validated);
        
        // Attacher les classes et matières
        if (isset($validated['classes'])) {
            $professeur->classes()->sync($validated['classes']);
        }
        
        if (isset($validated['matieres'])) {
            $professeur->matieres()->sync($validated['matieres']);
        }

        return redirect()->route('professeurs.show', $professeur->id)
                        ->with('success', 'Professeur créé avec succès.');
    }

    /**
     * Affiche les détails d'un professeur
     */
    public function show(Professeur $professeur)
    {
        $professeur->load(['classes', 'matieres', 'notes.eleve', 'absences.eleve']);
        
        // Statistiques
        $nombreEleves = $professeur->classes->sum(function($classe) {
            return $classe->eleves->count();
        });
        
        $moyenneNotes = $professeur->notes->avg('valeur');
        
        return view('professeurs.show', compact('professeur', 'nombreEleves', 'moyenneNotes'));
    }

    /**
     * Affiche le formulaire de modification d'un professeur
     */
    public function edit(Professeur $professeur)
    {
        $classes = Classe::orderBy('nom')->get();
        $matieres = Matiere::orderBy('nom')->get();
        
        return view('professeurs.edit', compact('professeur', 'classes', 'matieres'));
    }

    /**
     * Met à jour les informations d'un professeur
     */
    public function update(Request $request, Professeur $professeur)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:50',
            'prenom' => 'required|string|max:50',
            'date_naissance' => 'required|date',
            'sexe' => 'required|in:Masculin,Féminin',
            'adresse' => 'required|string|max:255',
            'telephone' => 'required|string|max:20',
            'email' => 'required|email|unique:professeurs,email,' . $professeur->id,
            'specialite' => 'required|string|max:100',
            'date_embauche' => 'required|date',
            'photo' => 'nullable|image|max:2048',
            'classes' => 'nullable|array',
            'classes.*' => 'exists:classes,id',
            'matieres' => 'nullable|array',
            'matieres.*' => 'exists:matieres,id',
        ]);

        // Gestion du téléversement de la photo
        if ($request->hasFile('photo')) {
            // Supprimer l'ancienne photo si elle existe
            if ($professeur->photo) {
                Storage::disk('public')->delete($professeur->photo);
            }
            
            $photoPath = $request->file('photo')->store('professeurs/photos', 'public');
            $validated['photo'] = $photoPath;
        }

        $professeur->update($validated);
        
        // Mettre à jour les relations
        $professeur->classes()->sync($request->input('classes', []));
        $professeur->matieres()->sync($request->input('matieres', []));

        return redirect()->route('professeurs.show', $professeur->id)
                        ->with('success', 'Professeur mis à jour avec succès.');
    }

    /**
     * Supprime un professeur
     */
    public function destroy(Professeur $professeur)
    {
        // Supprimer la photo si elle existe
        if ($professeur->photo) {
            Storage::disk('public')->delete($professeur->photo);
        }
        
        // Détacher les relations avant de supprimer
        $professeur->classes()->detach();
        $professeur->matieres()->detach();
        
        $professeur->delete();
        
        return redirect()->route('professeurs.index')
                        ->with('success', 'Professeur supprimé avec succès.');
    }
    
    /**
     * Affiche l'emploi du temps du professeur
     */
    public function emploiDuTemps(Professeur $professeur)
    {
        $professeur->load(['classes.emploisDuTemps' => function($query) use ($professeur) {
            $query->where('professeur_id', $professeur->id);
        }, 'matieres']);
        
        return view('professeurs.emploi-du-temps', compact('professeur'));
    }
    
    /**
     * Affiche les notes attribuées par le professeur
     */
    public function notes(Professeur $professeur)
    {
        $notes = $professeur->notes()
                          ->with(['eleve', 'matiere', 'classe'])
                          ->orderBy('date_evaluation', 'desc')
                          ->paginate(15);
        
        return view('professeurs.notes', compact('professeur', 'notes'));
    }
    
    /**
     * Affiche les absences enregistrées par le professeur
     */
    public function absences(Professeur $professeur)
    {
        $absences = $professeur->absences()
                             ->with(['eleve', 'matiere', 'classe'])
                             ->orderBy('date', 'desc')
                             ->paginate(15);
        
        return view('professeurs.absences', compact('professeur', 'absences'));
    }
}
