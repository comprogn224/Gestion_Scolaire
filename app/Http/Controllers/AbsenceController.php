<?php

namespace App\Http\Controllers;

use App\Models\Absence;
use App\Models\Eleve;
use App\Models\Matiere;
use App\Models\Classe;
use App\Models\Professeur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class AbsenceController extends Controller
{
    /**
     * Affiche la liste des absences avec filtrage
     */
    public function index()
    {
        $query = Absence::with(['eleve', 'matiere', 'classe', 'professeur']);
        
        // Filtrage par élève
        if (request()->has('eleve_id') && !empty(request('eleve_id'))) {
            $query->where('eleve_id', request('eleve_id'));
        }
        
        // Filtrage par matière
        if (request()->has('matiere_id') && !empty(request('matiere_id'))) {
            $query->where('matiere_id', request('matiere_id'));
        }
        
        // Filtrage par classe
        if (request()->has('classe_id') && !empty(request('classe_id'))) {
            $query->where('classe_id', request('classe_id'));
        }
        
        // Filtrage par statut de justification
        if (request()->has('justifiee') && in_array(request('justifiee'), ['0', '1'])) {
            $query->where('est_justifiee', request('justifiee'));
        }
        
        // Filtrage par date
        if (request()->has('date_debut') && !empty(request('date_debut'))) {
            $query->where('date', '>=', request('date_debut'));
        }
        
        if (request()->has('date_fin') && !empty(request('date_fin'))) {
            $query->where('date', '<=', request('date_fin'));
        }
        
        $absences = $query->orderBy('date', 'desc')->paginate(20);
        
        // Données pour les filtres
        $eleves = Eleve::orderBy('nom')->get();
        $matieres = Matiere::orderBy('nom')->get();
        $classes = Classe::orderBy('niveau')->orderBy('nom')->get();
        
        return view('absences.index', compact('absences', 'eleves', 'matieres', 'classes'));
    }

    /**
     * Affiche le formulaire de création d'une absence
     */
    public function create()
    {
        $eleves = Eleve::orderBy('nom')->orderBy('prenom')->get();
        $matieres = Matiere::orderBy('nom')->get();
        $classes = Classe::orderBy('niveau')->orderBy('nom')->get();
        $professeurs = Professeur::orderBy('nom')->get();
        
        return view('absences.create', compact('eleves', 'matieres', 'classes', 'professeurs'));
    }

    /**
     * Enregistre une nouvelle absence
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'eleve_id' => 'required|exists:eleves,id',
            'matiere_id' => 'required|exists:matieres,id',
            'classe_id' => 'required|exists:classes,id',
            'professeur_id' => 'required|exists:professeurs,id',
            'date' => 'required|date',
            'heure_debut' => 'required|date_format:H:i',
            'heure_fin' => 'required|date_format:H:i|after:heure_debut',
            'motif' => 'required|string|max:255',
            'est_justifiee' => 'boolean',
            'justificatif' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'commentaire' => 'nullable|string|max:500',
        ]);
        
        // Vérifier que l'élève appartient bien à la classe spécifiée
        $eleve = Eleve::findOrFail($validated['eleve_id']);
        if ($eleve->classe_id != $validated['classe_id']) {
            return back()->withInput()->with('error', 'L\'élève sélectionné n\'appartient pas à la classe spécifiée.');
        }
        
        // Vérifier que la matière est bien enseignée dans la classe
        $matiere = Matiere::findOrFail($validated['matiere_id']);
        if (!$matiere->classes->contains('id', $validated['classe_id'])) {
            return back()->withInput()->with('error', 'La matière sélectionnée n\'est pas enseignée dans cette classe.');
        }
        
        // Vérifier que le professeur enseigne bien la matière
        $professeur = Professeur::findOrFail($validated['professeur_id']);
        if (!$professeur->matieres->contains('id', $validated['matiere_id'])) {
            return back()->withInput()->with('error', 'Le professeur sélectionné n\'enseigne pas cette matière.');
        }
        
        // Gestion du téléversement du justificatif
        if ($request->hasFile('justificatif')) {
            $path = $request->file('justificatif')->store('absences/justificatifs', 'public');
            $validated['chemin_justificatif'] = $path;
            $validated['est_justifiee'] = true;
        } elseif ($request->has('est_justifiee') && $request->est_justifiee) {
            return back()->withInput()->with('error', 'Un justificatif est requis pour une absence justifiée.');
        }
        
        try {
            Absence::create($validated);
            
            return redirect()->route('absences.index')
                            ->with('success', 'Absence enregistrée avec succès.');
                            
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Une erreur est survenue lors de l\'enregistrement de l\'absence.');
        }
    }

    /**
     * Affiche les détails d'une absence
     */
    public function show(Absence $absence)
    {
        $absence->load(['eleve', 'matiere', 'classe', 'professeur']);
        return view('absences.show', compact('absence'));
    }

    /**
     * Affiche le formulaire de modification d'une absence
     */
    public function edit(Absence $absence)
    {
        $eleves = Eleve::orderBy('nom')->orderBy('prenom')->get();
        $matieres = Matiere::orderBy('nom')->get();
        $classes = Classe::orderBy('niveau')->orderBy('nom')->get();
        $professeurs = Professeur::orderBy('nom')->get();
        
        return view('absences.edit', compact('absence', 'eleves', 'matieres', 'classes', 'professeurs'));
    }

    /**
     * Met à jour une absence existante
     */
    public function update(Request $request, Absence $absence)
    {
        $validated = $request->validate([
            'eleve_id' => 'required|exists:eleves,id',
            'matiere_id' => 'required|exists:matieres,id',
            'classe_id' => 'required|exists:classes,id',
            'professeur_id' => 'required|exists:professeurs,id',
            'date' => 'required|date',
            'heure_debut' => 'required|date_format:H:i',
            'heure_fin' => 'required|date_format:H:i|after:heure_debut',
            'motif' => 'required|string|max:255',
            'est_justifiee' => 'boolean',
            'justificatif' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'commentaire' => 'nullable|string|max:500',
        ]);
        
        // Vérifier que l'élève appartient bien à la classe spécifiée
        $eleve = Eleve::findOrFail($validated['eleve_id']);
        if ($eleve->classe_id != $validated['classe_id']) {
            return back()->withInput()->with('error', 'L\'élève sélectionné n\'appartient pas à la classe spécifiée.');
        }
        
        // Vérifier que la matière est bien enseignée dans la classe
        $matiere = Matiere::findOrFail($validated['matiere_id']);
        if (!$matiere->classes->contains('id', $validated['classe_id'])) {
            return back()->withInput()->with('error', 'La matière sélectionnée n\'est pas enseignée dans cette classe.');
        }
        
        // Vérifier que le professeur enseigne bien la matière
        $professeur = Professeur::findOrFail($validated['professeur_id']);
        if (!$professeur->matieres->contains('id', $validated['matiere_id'])) {
            return back()->withInput()->with('error', 'Le professeur sélectionné n\'enseigne pas cette matière.');
        }
        
        // Gestion du téléversement du justificatif
        if ($request->hasFile('justificatif')) {
            // Supprimer l'ancien justificatif s'il existe
            if ($absence->chemin_justificatif) {
                Storage::disk('public')->delete($absence->chemin_justificatif);
            }
            
            $path = $request->file('justificatif')->store('absences/justificatifs', 'public');
            $validated['chemin_justificatif'] = $path;
            $validated['est_justifiee'] = true;
        } elseif ($request->has('est_justifiee') && $request->est_justifiee && !$absence->chemin_justificatif) {
            return back()->withInput()->with('error', 'Un justificatif est requis pour une absence justifiée.');
        } elseif (!$request->has('est_justifiee') || !$request->est_justifiee) {
            // Si on décoche "est_justifiée", on supprime le justificatif s'il existe
            if ($absence->chemin_justificatif) {
                Storage::disk('public')->delete($absence->chemin_justificatif);
                $validated['chemin_justificatif'] = null;
            }
        }
        
        try {
            $absence->update($validated);
            
            return redirect()->route('absences.show', $absence->id)
                            ->with('success', 'Absence mise à jour avec succès.');
                            
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Une erreur est survenue lors de la mise à jour de l\'absence.');
        }
    }

    /**
     * Supprime une absence
     */
    public function destroy(Absence $absence)
    {
        try {
            // Supprimer le justificatif s'il existe
            if ($absence->chemin_justificatif) {
                Storage::disk('public')->delete($absence->chemin_justificatif);
            }
            
            $absence->delete();
            
            return redirect()->route('absences.index')
                            ->with('success', 'Absence supprimée avec succès.');
                            
        } catch (\Exception $e) {
            return back()->with('error', 'Une erreur est survenue lors de la suppression de l\'absence.');
        }
    }
    
    /**
     * Télécharge le justificatif d'une absence
     */
    public function telechargerJustificatif(Absence $absence)
    {
        if (!$absence->chemin_justificatif || !Storage::disk('public')->exists($absence->chemin_justificatif)) {
            return back()->with('error', 'Aucun justificatif trouvé pour cette absence.');
        }
        
        return Storage::disk('public')->download(
            $absence->chemin_justificatif, 
            'justificatif_absence_' . $absence->id . '.' . pathinfo($absence->chemin_justificatif, PATHINFO_EXTENSION)
        );
    }
    
    /**
     * Affiche le formulaire d'import d'absences
     */
    public function showImportForm()
    {
        $matieres = Matiere::orderBy('nom')->get();
        $classes = Classe::orderBy('niveau')->orderBy('nom')->get();
        $professeurs = Professeur::orderBy('nom')->get();
        
        return view('absences.import', compact('matieres', 'classes', 'professeurs'));
    }
    
    /**
     * Importe des absences à partir d'un fichier Excel/CSV
     */
    public function import(Request $request)
    {
        $request->validate([
            'fichier' => 'required|file|mimes:xlsx,xls,csv',
            'matiere_id' => 'required|exists:matieres,id',
            'classe_id' => 'required|exists:classes,id',
            'professeur_id' => 'required|exists:professeurs,id',
            'date' => 'required|date',
            'heure_debut' => 'required|date_format:H:i',
            'heure_fin' => 'required|date_format:H:i|after:heure_debut',
            'motif' => 'required|string|max:255',
            'est_justifiee' => 'boolean',
        ]);
        
        // Vérifier que la matière est bien enseignée dans la classe
        $matiere = Matiere::findOrFail($request->matiere_id);
        if (!$matiere->classes->contains('id', $request->classe_id)) {
            return back()->with('error', 'La matière sélectionnée n\'est pas enseignée dans cette classe.');
        }
        
        // Vérifier que le professeur enseigne bien la matière
        $professeur = Professeur::findOrFail($request->professeur_id);
        if (!$professeur->matieres->contains('id', $request->matiere_id)) {
            return back()->with('error', 'Le professeur sélectionné n\'enseigne pas cette matière.');
        }
        
        try {
            $file = $request->file('fichier');
            $extension = $file->getClientOriginalExtension();
            
            // Lire le fichier Excel/CSV
            $data = [];
            
            if (in_array($extension, ['xlsx', 'xls'])) {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
                $spreadsheet = $reader->load($file->getPathname());
                $sheet = $spreadsheet->getActiveSheet();
                $data = $sheet->toArray();
            } else {
                $file = fopen($file->getPathname(), 'r');
                while (($row = fgetcsv($file)) !== false) {
                    $data[] = $row;
                }
                fclose($file);
            }
            
            // Vérifier le format du fichier (au moins 1 colonne: identifiant_eleve)
            if (count($data) < 2 || count($data[0]) < 1) {
                return back()->with('error', 'Format de fichier invalide. Le fichier doit contenir au moins une colonne avec l\'identifiant de l\'élève.');
            }
            
            // En-têtes de colonnes
            $headers = array_shift($data);
            $idIndex = array_search('identifiant', array_map('strtolower', $headers));
            
            if ($idIndex === false) {
                return back()->with('error', 'Format de fichier invalide. La colonne doit s\'appeler "identifiant".');
            }
            
            DB::beginTransaction();
            
            $imported = 0;
            $errors = [];
            
            foreach ($data as $index => $row) {
                $identifiant = trim($row[$idIndex]);
                
                // Trouver l'élève par son identifiant (matricule ou email)
                $eleve = Eleve::where('matricule', $identifiant)
                             ->orWhere('email', $identifiant)
                             ->where('classe_id', $request->classe_id)
                             ->first();
                
                if (!$eleve) {
                    $errors[] = "Ligne " . ($index + 2) . ": Aucun élève trouvé avec l'identifiant " . $identifiant . " dans cette classe.";
                    continue;
                }
                
                // Vérifier si une absence existe déjà pour cet élève, cette matière et cette date
                $existingAbsence = Absence::where('eleve_id', $eleve->id)
                                        ->where('matiere_id', $request->matiere_id)
                                        ->where('classe_id', $request->classe_id)
                                        ->where('date', $request->date)
                                        ->where(function($query) use ($request) {
                                            $query->whereBetween('heure_debut', [$request->heure_debut, $request->heure_fin])
                                                  ->orWhereBetween('heure_fin', [$request->heure_debut, $request->heure_fin])
                                                  ->orWhere(function($q) use ($request) {
                                                      $q->where('heure_debut', '<=', $request->heure_debut)
                                                        ->where('heure_fin', '>=', $request->heure_fin);
                                                  });
                                        })
                                        ->first();
                
                if ($existingAbsence) {
                    $errors[] = "Ligne " . ($index + 2) . ": Une absence existe déjà pour cet élève sur ce créneau horaire.";
                    continue;
                }
                
                // Créer l'absence
                Absence::create([
                    'eleve_id' => $eleve->id,
                    'matiere_id' => $request->matiere_id,
                    'classe_id' => $request->classe_id,
                    'professeur_id' => $request->professeur_id,
                    'date' => $request->date,
                    'heure_debut' => $request->heure_debut,
                    'heure_fin' => $request->heure_fin,
                    'motif' => $request->motif,
                    'est_justifiee' => $request->has('est_justifiee') && $request->est_justifiee,
                    'commentaire' => 'Importé le ' . now()->format('d/m/Y'),
                ]);
                
                $imported++;
            }
            
            DB::commit();
            
            $message = $imported . ' absence(s) importée(s) avec succès.';
            
            if (!empty($errors)) {
                $message .= ' ' . count($errors) . ' erreur(s) lors de l\'importation.';
                return back()->with('warning', $message)->with('import_errors', $errors);
            }
            
            return back()->with('success', $message);
            
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Une erreur est survenue lors de l\'importation du fichier: ' . $e->getMessage());
        }
    }
    
    /**
     * Exporte les absences au format Excel
     */
    public function export(Request $request)
    {
        $request->validate([
            'matiere_id' => 'nullable|exists:matieres,id',
            'classe_id' => 'nullable|exists:classes,id',
            'date_debut' => 'nullable|date',
            'date_fin' => 'nullable|date|after_or_equal:date_debut',
            'justifiee' => 'nullable|in:0,1',
        ]);
        
        $query = Absence::with(['eleve', 'matiere', 'classe', 'professeur']);
        
        if ($request->has('matiere_id') && !empty($request->matiere_id)) {
            $query->where('matiere_id', $request->matiere_id);
        }
        
        if ($request->has('classe_id') && !empty($request->classe_id)) {
            $query->where('classe_id', $request->classe_id);
        }
        
        if ($request->has('date_debut') && !empty($request->date_debut)) {
            $query->where('date', '>=', $request->date_debut);
        }
        
        if ($request->has('date_fin') && !empty($request->date_fin)) {
            $query->where('date', '<=', $request->date_fin);
        }
        
        if ($request->has('justifiee') && in_array($request->justifiee, ['0', '1'])) {
            $query->where('est_justifiee', $request->justifiee);
        }
        
        $absences = $query->orderBy('date', 'desc')->orderBy('heure_debut')->get();
        
        if ($absences->isEmpty()) {
            return back()->with('error', 'Aucune absence trouvée avec les critères sélectionnés.');
        }
        
        try {
            $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            
            // En-têtes
            $sheet->setCellValue('A1', 'Date');
            $sheet->setCellValue('B1', 'Heure début');
            $sheet->setCellValue('C1', 'Heure fin');
            $sheet->setCellValue('D1', 'Élève');
            $sheet->setCellValue('E1', 'Classe');
            $sheet->setCellValue('F1', 'Matière');
            $sheet->setCellValue('G1', 'Professeur');
            $sheet->setCellValue('H1', 'Motif');
            $sheet->setCellValue('I1', 'Statut');
            $sheet->setCellValue('J1', 'Commentaire');
            
            // Style des en-têtes
            $headerStyle = [
                'font' => ['bold' => true],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'E0E0E0']
                ]
            ];
            
            $sheet->getStyle('A1:J1')->applyFromArray($headerStyle);
            
            // Données
            $row = 2;
            
            foreach ($absences as $absence) {
                $sheet->setCellValue('A' . $row, $absence->date->format('d/m/Y'));
                $sheet->setCellValue('B' . $row, $absence->heure_debut);
                $sheet->setCellValue('C' . $row, $absence->heure_fin);
                $sheet->setCellValue('D' . $row, $absence->eleve->nom_complet);
                $sheet->setCellValue('E' . $row, $absence->classe->libelle_complet);
                $sheet->setCellValue('F' . $row, $absence->matiere->nom);
                $sheet->setCellValue('G' . $row, $absence->professeur->nom_complet);
                $sheet->setCellValue('H' . $row, $absence->motif);
                $sheet->setCellValue('I' . $row, $absence->est_justifiee ? 'Justifiée' : 'Non justifiée');
                $sheet->setCellValue('J' . $row, $absence->commentaire);
                
                // Mise en forme conditionnelle pour les absences non justifiées
                if (!$absence->est_justifiee) {
                    $sheet->getStyle('A' . $row . ':J' . $row)->applyFromArray([
                        'font' => ['color' => ['rgb' => 'FF0000']],
                        'fill' => [
                            'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                            'startColor' => ['rgb' => 'FFE6E6']
                        ]
                    ]);
                }
                
                $row++;
            }
            
            // Largeur des colonnes
            foreach (range('A', 'J') as $col) {
                $sheet->getColumnDimension($col)->setAutoSize(true);
            }
            
            // Ajout d'un tableau de synthèse
            $sheet->setCellValue('L1', 'Synthèse');
            $sheet->setCellValue('L2', 'Total des absences:');
            $sheet->setCellValue('M2', '=COUNT(A2:A' . ($row - 1) . ')');
            
            $sheet->setCellValue('L3', 'Absences justifiées:');
            $sheet->setCellValue('M3', '=COUNTIF(I2:I' . ($row - 1) . ',"Justifiée")');
            
            $sheet->setCellValue('L4', 'Absences non justifiées:');
            $sheet->setCellValue('M4', '=COUNTIF(I2:I' . ($row - 1) . ',"Non justifiée")');
            
            $sheet->setCellValue('L5', 'Taux d\'absentéisme:');
            $sheet->setCellValue('M5', '=M2/(' . ($row - 2) . '/' . $absences->groupBy('eleve_id')->count() . ')';
            $sheet->getStyle('M5')->getNumberFormat()->setFormatCode('0.00');
            
            // Style de la synthèse
            $sheet->getStyle('L1:M5')->applyFromArray([
                'font' => ['bold' => true],
                'borders' => [
                    'allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                ],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'F5F5F5']
                ]
            ]);
            
            // Enregistrement du fichier
            $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
            
            $fileName = 'absences_export_' . date('Y-m-d_His') . '.xlsx';
            $tempFile = tempnam(sys_get_temp_dir(), $fileName);
            $writer->save($tempFile);
            
            return response()->download($tempFile, $fileName)->deleteFileAfterSend(true);
            
        } catch (\Exception $e) {
            return back()->with('error', 'Une erreur est survenue lors de l\'exportation des absences: ' . $e->getMessage());
        }
    }
    
    /**
     * Affiche les statistiques des absences
     */
    public function statistiques()
    {
        $query = Absence::with(['eleve', 'matiere', 'classe']);
        
        // Filtrage par classe
        if (request()->has('classe_id') && !empty(request('classe_id'))) {
            $query->where('classe_id', request('classe_id'));
        }
        
        // Filtrage par date
        if (request()->has('date_debut') && !empty(request('date_debut'))) {
            $query->where('date', '>=', request('date_debut'));
        }
        
        if (request()->has('date_fin') && !empty(request('date_fin'))) {
            $query->where('date', '<=', request('date_fin'));
        }
        
        $absences = $query->get();
        
        // Données pour les filtres
        $classes = Classe::orderBy('niveau')->orderBy('nom')->get();
        
        // Statistiques générales
        $totalAbsences = $absences->count();
        $absencesJustifiees = $absences->where('est_justifiee', true)->count();
        $tauxAbsenteisme = $totalAbsences > 0 ? ($totalAbsences / $absences->groupBy('eleve_id')->count()) : 0;
        
        // Statistiques par matière
        $statistiquesMatieres = $absences->groupBy('matiere_id')->map(function ($absencesMatiere) {
            return [
                'matiere' => $absencesMatiere->first()->matiere->nom,
                'total' => $absencesMatiere->count(),
                'justifiees' => $absencesMatiere->where('est_justifiee', true)->count(),
                'taux' => $absencesMatiere->count() > 0 ? 
                    ($absencesMatiere->where('est_justifiee', true)->count() / $absencesMatiere->count()) * 100 : 0
            ];
        })->sortByDesc('total');
        
        // Statistiques par élève
        $statistiquesEleves = $absences->groupBy('eleve_id')->map(function ($absencesEleve) {
            return [
                'eleve' => $absencesEleve->first()->eleve->nom_complet,
                'classe' => $absencesEleve->first()->classe->libelle_complet,
                'total' => $absencesEleve->count(),
                'justifiees' => $absencesEleve->where('est_justifiee', true)->count(),
                'taux' => $absencesEleve->count() > 0 ? 
                    ($absencesEleve->where('est_justifiee', true)->count() / $absencesEleve->count()) * 100 : 0
            ];
        })->sortByDesc('total');
        
        // Évolution mensuelle des absences
        $evolutionMensuelle = $absences->groupBy(function($absence) {
            return Carbon::parse($absence->date)->format('Y-m');
        })->map(function($absencesMois) {
            return [
                'mois' => Carbon::parse($absencesMois->first()->date)->isoFormat('MMMM YYYY'),
                'total' => $absencesMois->count(),
                'justifiees' => $absencesMois->where('est_justifiee', true)->count(),
                'non_justifiees' => $absencesMois->where('est_justifiee', false)->count()
            ];
        })->sortKeys();
        
        return view('absences.statistiques', compact(
            'classes', 
            'totalAbsences', 
            'absencesJustifiees', 
            'tauxAbsenteisme',
            'statistiquesMatieres',
            'statistiquesEleves',
            'evolutionMensuelle'
        ));
    }
}
