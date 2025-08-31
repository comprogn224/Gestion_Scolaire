<?php

namespace App\Http\Controllers;

use App\Models\Classe;
use App\Models\Professeur;
use App\Models\Matiere;
use App\Models\Eleve;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClasseController extends Controller
{
    /**
     * Affiche la liste des classes
     */
    public function index()
    {
        $classes = Classe::with(['professeurPrincipal', 'eleves', 'matieres'])
                         ->withCount('eleves')
                         ->orderBy('niveau')
                         ->orderBy('nom')
                         ->paginate(15);
        
        return view('classes.index', compact('classes'));
    }

    /**
     * Affiche le formulaire de création d'une classe
     */
    public function create()
    {
        $professeurs = Professeur::orderBy('nom')->get();
        $matieres = Matiere::orderBy('nom')->get();
        
        return view('classes.create', compact('professeurs', 'matieres'));
    }

    /**
     * Enregistre une nouvelle classe
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:50',
            'niveau' => 'required|string|max:50',
            'annee_scolaire' => 'required|string|max:20',
            'effectif_max' => 'required|integer|min:1',
            'professeur_principal_id' => 'required|exists:professeurs,id',
            'description' => 'nullable|string',
            'matieres' => 'required|array|min:1',
            'matieres.*' => 'exists:matieres,id',
        ]);

        DB::beginTransaction();
        
        try {
            // Création de la classe
            $classe = Classe::create($validated);
            
            // Attacher les matières à la classe
            $classe->matieres()->sync($validated['matieres']);
            
            DB::commit();
            
            return redirect()->route('classes.show', $classe->id)
                            ->with('success', 'Classe créée avec succès.');
                            
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Une erreur est survenue lors de la création de la classe.');
        }
    }

    /**
     * Affiche les détails d'une classe
     */
    public function show(Classe $classe)
    {
        $classe->load([
            'professeurPrincipal', 
            'eleves' => function($query) {
                $query->orderBy('nom')->orderBy('prenom');
            },
            'matieres',
            'notes' => function($query) {
                $query->orderBy('date_evaluation', 'desc')->limit(10);
            },
            'absences' => function($query) {
                $query->orderBy('date', 'desc')->limit(10);
            }
        ]);
        
        // Statistiques
        $effectif = $classe->eleves->count();
        $moyenneClasse = $classe->notes->avg('valeur');
        $tauxAbsentee = $classe->absences->count() / max($effectif, 1);
        
        return view('classes.show', compact('classe', 'effectif', 'moyenneClasse', 'tauxAbsentee'));
    }

    /**
     * Affiche le formulaire de modification d'une classe
     */
    public function edit(Classe $classe)
    {
        $professeurs = Professeur::orderBy('nom')->get();
        $matieres = Matiere::orderBy('nom')->get();
        
        return view('classes.edit', compact('classe', 'professeurs', 'matieres'));
    }

    /**
     * Met à jour les informations d'une classe
     */
    public function update(Request $request, Classe $classe)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:50',
            'niveau' => 'required|string|max:50',
            'annee_scolaire' => 'required|string|max:20',
            'effectif_max' => 'required|integer|min:1',
            'professeur_principal_id' => 'required|exists:professeurs,id',
            'description' => 'nullable|string',
            'matieres' => 'required|array|min:1',
            'matieres.*' => 'exists:matieres,id',
        ]);

        DB::beginTransaction();
        
        try {
            // Mise à jour de la classe
            $classe->update($validated);
            
            // Mise à jour des matières de la classe
            $classe->matieres()->sync($validated['matieres']);
            
            DB::commit();
            
            return redirect()->route('classes.show', $classe->id)
                            ->with('success', 'Classe mise à jour avec succès.');
                            
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Une erreur est survenue lors de la mise à jour de la classe.');
        }
    }

    /**
     * Supprime une classe
     */
    public function destroy(Classe $classe)
    {
        // Vérifier s'il y a des élèves dans la classe
        if ($classe->eleves()->exists()) {
            return back()->with('error', 'Impossible de supprimer une classe contenant des élèves.');
        }
        
        DB::beginTransaction();
        
        try {
            // Détacher les relations avant de supprimer
            $classe->matieres()->detach();
            
            // Supprimer les notes et absences liées
            $classe->notes()->delete();
            $classe->absences()->delete();
            
            $classe->delete();
            
            DB::commit();
            
            return redirect()->route('classes.index')
                            ->with('success', 'Classe supprimée avec succès.');
                            
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Une erreur est survenue lors de la suppression de la classe.');
        }
    }
    
    /**
     * Affiche la liste des élèves d'une classe
     */
    public function eleves(Classe $classe)
    {
        $eleves = $classe->eleves()
                        ->orderBy('nom')
                        ->orderBy('prenom')
                        ->paginate(20);
        
        return view('classes.eleves', compact('classe', 'eleves'));
    }
    
    /**
     * Affiche les notes d'une classe
     */
    public function notes(Classe $classe)
    {
        $matiereId = request('matiere_id');
        
        $query = $classe->notes()
                       ->with(['eleve', 'matiere', 'professeur'])
                       ->orderBy('date_evaluation', 'desc');
        
        if ($matiereId) {
            $query->where('matiere_id', $matiereId);
        }
        
        $notes = $query->paginate(20);
        $matieres = $classe->matieres;
        
        return view('classes.notes', compact('classe', 'notes', 'matieres', 'matiereId'));
    }
    
    /**
     * Affiche les statistiques d'une classe
     */
    public function statistiques(Classe $classe)
    {
        $classe->load(['eleves.notes', 'matieres']);
        
        // Calcul des moyennes par matière
        $moyennesParMatiere = [];
        foreach ($classe->matieres as $matiere) {
            $moyenne = $classe->notes()
                             ->where('matiere_id', $matiere->id)
                             ->avg('valeur');
            
            $moyennesParMatiere[$matiere->nom] = $moyenne;
        }
        
        // Répartition des notes
        $repartitionNotes = [
            '0-5' => $classe->notes()->whereBetween('valeur', [0, 4.99])->count(),
            '5-10' => $classe->notes()->whereBetween('valeur', [5, 9.99])->count(),
            '10-15' => $classe->notes()->whereBetween('valeur', [10, 14.99])->count(),
            '15-20' => $classe->notes()->whereBetween('valeur', [15, 20])->count(),
        ];
        
        // Taux de réussite
        $totalNotes = $classe->notes()->count();
        $notesReussies = $classe->notes()->where('valeur', '>=', 10)->count();
        $tauxReussite = $totalNotes > 0 ? ($notesReussies / $totalNotes) * 100 : 0;
        
        return view('classes.statistiques', compact(
            'classe', 
            'moyennesParMatiere', 
            'repartitionNotes', 
            'tauxReussite'
        ));
    }
}
