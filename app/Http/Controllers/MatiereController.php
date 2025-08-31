<?php

namespace App\Http\Controllers;

use App\Models\Matiere;
use App\Models\Classe;
use App\Models\Professeur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MatiereController extends Controller
{
    /**
     * Affiche la liste des matières
     */
    public function index()
    {
        $matieres = Matiere::with(['professeur', 'classes'])
                          ->withCount('eleves')
                          ->orderBy('nom')
                          ->paginate(15);
        
        return view('matieres.index', compact('matieres'));
    }

    /**
     * Affiche le formulaire de création d'une matière
     */
    public function create()
    {
        $professeurs = Professeur::orderBy('nom')->get();
        $classes = Classe::orderBy('niveau')->orderBy('nom')->get();
        
        return view('matieres.create', compact('professeurs', 'classes'));
    }

    /**
     * Enregistre une nouvelle matière
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:20|unique:matieres,code',
            'nom' => 'required|string|max:100',
            'description' => 'nullable|string',
            'coefficient' => 'required|numeric|min:0.5|max:5',
            'volume_horaire' => 'required|integer|min:1',
            'professeur_id' => 'nullable|exists:professeurs,id',
            'classes' => 'nullable|array',
            'classes.*' => 'exists:classes,id',
        ]);

        DB::beginTransaction();
        
        try {
            // Création de la matière
            $matiere = Matiere::create($validated);
            
            // Attacher les classes à la matière
            if (isset($validated['classes'])) {
                $matiere->classes()->sync($validated['classes']);
            }
            
            DB::commit();
            
            return redirect()->route('matieres.show', $matiere->id)
                            ->with('success', 'Matière créée avec succès.');
                            
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Une erreur est survenue lors de la création de la matière.');
        }
    }

    /**
     * Affiche les détails d'une matière
     */
    public function show(Matiere $matiere)
    {
        $matiere->load([
            'professeur', 
            'classes',
            'notes' => function($query) {
                $query->orderBy('date_evaluation', 'desc')->limit(10);
            },
            'absences' => function($query) {
                $query->orderBy('date', 'desc')->limit(10);
            }
        ]);
        
        // Statistiques
        $nombreEleves = $matiere->eleves()->count();
        $moyenneGenerale = $matiere->notes->avg('valeur');
        $tauxAbsentee = $matiere->absences->count() / max($nombreEleves, 1);
        
        return view('matieres.show', compact('matiere', 'nombreEleves', 'moyenneGenerale', 'tauxAbsentee'));
    }

    /**
     * Affiche le formulaire de modification d'une matière
     */
    public function edit(Matiere $matiere)
    {
        $professeurs = Professeur::orderBy('nom')->get();
        $classes = Classe::orderBy('niveau')->orderBy('nom')->get();
        
        return view('matieres.edit', compact('matiere', 'professeurs', 'classes'));
    }

    /**
     * Met à jour les informations d'une matière
     */
    public function update(Request $request, Matiere $matiere)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:20|unique:matieres,code,' . $matiere->id,
            'nom' => 'required|string|max:100',
            'description' => 'nullable|string',
            'coefficient' => 'required|numeric|min:0.5|max:5',
            'volume_horaire' => 'required|integer|min:1',
            'professeur_id' => 'nullable|exists:professeurs,id',
            'classes' => 'nullable|array',
            'classes.*' => 'exists:classes,id',
        ]);

        DB::beginTransaction();
        
        try {
            // Mise à jour de la matière
            $matiere->update($validated);
            
            // Mise à jour des classes de la matière
            $matiere->classes()->sync($request->input('classes', []));
            
            DB::commit();
            
            return redirect()->route('matieres.show', $matiere->id)
                            ->with('success', 'Matière mise à jour avec succès.');
                            
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Une erreur est survenue lors de la mise à jour de la matière.');
        }
    }

    /**
     * Supprime une matière
     */
    public function destroy(Matiere $matiere)
    {
        // Vérifier s'il y a des notes ou des absences liées
        if ($matiere->notes()->exists() || $matiere->absences()->exists()) {
            return back()->with('error', 'Impossible de supprimer une matière associée à des notes ou des absences.');
        }
        
        DB::beginTransaction();
        
        try {
            // Détacher les relations avant de supprimer
            $matiere->classes()->detach();
            $matiere->professeurs()->detach();
            
            $matiere->delete();
            
            DB::commit();
            
            return redirect()->route('matieres.index')
                            ->with('success', 'Matière supprimée avec succès.');
                            
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Une erreur est survenue lors de la suppression de la matière.');
        }
    }
    
    /**
     * Affiche les notes d'une matière
     */
    public function notes(Matiere $matiere)
    {
        $classeId = request('classe_id');
        
        $query = $matiere->notes()
                        ->with(['eleve', 'classe', 'professeur'])
                        ->orderBy('date_evaluation', 'desc');
        
        if ($classeId) {
            $query->where('classe_id', $classeId);
        }
        
        $notes = $query->paginate(20);
        $classes = $matiere->classes;
        
        return view('matieres.notes', compact('matiere', 'notes', 'classes', 'classeId'));
    }
    
    /**
     * Affiche les statistiques d'une matière
     */
    public function statistiques(Matiere $matiere)
    {
        $matiere->load(['notes.classe', 'absences.eleve']);
        
        // Moyenne par classe
        $moyennesParClasse = [];
        foreach ($matiere->classes as $classe) {
            $moyenne = $matiere->notes()
                              ->where('classe_id', $classe->id)
                              ->avg('valeur');
            
            if ($moyenne !== null) {
                $moyennesParClasse[$classe->libelle_complet] = $moyenne;
            }
        }
        
        // Répartition des notes
        $repartitionNotes = [
            '0-5' => $matiere->notes()->whereBetween('valeur', [0, 4.99])->count(),
            '5-10' => $matiere->notes()->whereBetween('valeur', [5, 9.99])->count(),
            '10-15' => $matiere->notes()->whereBetween('valeur', [10, 14.99])->count(),
            '15-20' => $matiere->notes()->whereBetween('valeur', [15, 20])->count(),
        ];
        
        // Taux de réussite
        $totalNotes = $matiere->notes()->count();
        $notesReussies = $matiere->notes()->where('valeur', '>=', 10)->count();
        $tauxReussite = $totalNotes > 0 ? ($notesReussies / $totalNotes) * 100 : 0;
        
        // Taux d'absentéisme
        $totalEleves = $matiere->eleves()->count();
        $totalAbsences = $matiere->absences->count();
        $tauxAbsentee = $totalEleves > 0 ? ($totalAbsences / $totalEleves) * 100 : 0;
        
        return view('matieres.statistiques', compact(
            'matiere', 
            'moyennesParClasse', 
            'repartitionNotes', 
            'tauxReussite',
            'tauxAbsentee'
        ));
    }
}
