<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\EleveResource;
use App\Models\Eleve;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EleveController extends Controller
{
    /**
     * Affiche la liste des élèves
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $eleves = Eleve::with(['classe', 'notes', 'absences'])->paginate(15);
        return EleveResource::collection($eleves);
    }

    /**
     * Enregistre un nouvel élève
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
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

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $data = $validator->validated();

        // Gestion du téléversement de la photo si elle existe
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('eleves/photos', 'public');
            $data['photo'] = $path;
        }

        $eleve = Eleve::create($data);

        return new EleveResource($eleve->load('classe'));
    }

    /**
     * Affiche les détails d'un élève
     *
     * @param  \App\Models\Eleve  $eleve
     * @return \App\Http\Resources\EleveResource
     */
    public function show(Eleve $eleve)
    {
        return new EleveResource($eleve->load(['classe', 'notes', 'absences']));
    }

    /**
     * Met à jour les informations d'un élève
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Eleve  $eleve
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Eleve $eleve)
    {
        $validator = Validator::make($request->all(), [
            'nom' => 'sometimes|required|string|max:50',
            'prenom' => 'sometimes|required|string|max:50',
            'date_naissance' => 'sometimes|required|date',
            'sexe' => 'sometimes|required|in:Masculin,Féminin',
            'adresse' => 'sometimes|required|string|max:255',
            'telephone' => 'nullable|string|max:20',
            'email' => 'nullable|email|unique:eleves,email,' . $eleve->id,
            'classe_id' => 'sometimes|required|exists:classes,id',
            'photo' => 'nullable|image|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $data = $validator->validated();

        // Gestion du téléversement de la photo si elle existe
        if ($request->hasFile('photo')) {
            // Supprimer l'ancienne photo si elle existe
            if ($eleve->photo) {
                \Storage::disk('public')->delete($eleve->photo);
            }
            
            $path = $request->file('photo')->store('eleves/photos', 'public');
            $data['photo'] = $path;
        }

        $eleve->update($data);

        return new EleveResource($eleve->load('classe'));
    }

    /**
     * Supprime un élève
     *
     * @param  \App\Models\Eleve  $eleve
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Eleve $eleve)
    {
        // Supprimer la photo si elle existe
        if ($eleve->photo) {
            \Storage::disk('public')->delete($eleve->photo);
        }
        
        $eleve->delete();
        
        return response()->json(['message' => 'Élève supprimé avec succès'], 200);
    }

    /**
     * Récupère le bulletin de notes d'un élève
     *
     * @param  \App\Models\Eleve  $eleve
     * @return \Illuminate\Http\JsonResponse
     */
    public function bulletin(Eleve $eleve)
    {
        $eleve->load(['classe', 'notes.matiere', 'absences']);
        
        // Calcul des moyennes par matière
        $notesParMatiere = $eleve->notes->groupBy('matiere.nom')->map(function ($notes, $matiere) {
            return [
                'matiere' => $matiere,
                'notes' => $notes->map->only(['valeur', 'coefficient', 'type_note', 'date_evaluation']),
                'moyenne' => round($notes->avg('valeur'), 2),
                'coefficient_total' => $notes->sum('coefficient'),
            ];
        });
        
        // Calcul de la moyenne générale
        $moyenneGenerale = $eleve->notes->avg('valeur');
        
        return response()->json([
            'eleve' => new EleveResource($eleve),
            'notes_par_matiere' => $notesParMatiere,
            'moyenne_generale' => round($moyenneGenerale, 2),
            'absences' => $eleve->absences->map->only(['date', 'motif', 'justifiee']),
        ]);
    }
}
