<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\Eleve;
use App\Models\Matiere;
use App\Models\Classe;
use App\Models\Professeur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class NoteController extends Controller
{
    /**
     * Affiche la liste des notes avec filtrage
     */
    public function index()
    {
        $query = Note::with(['eleve', 'matiere', 'classe', 'professeur']);
        
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
        
        // Filtrage par date
        if (request()->has('date_debut') && !empty(request('date_debut'))) {
            $query->where('date_evaluation', '>=', request('date_debut'));
        }
        
        if (request()->has('date_fin') && !empty(request('date_fin'))) {
            $query->where('date_evaluation', '<=', request('date_fin'));
        }
        
        $notes = $query->orderBy('date_evaluation', 'desc')->paginate(20);
        
        // Données pour les filtres
        $eleves = Eleve::orderBy('nom')->get();
        $matieres = Matiere::orderBy('nom')->get();
        $classes = Classe::orderBy('niveau')->orderBy('nom')->get();
        
        return view('notes.index', compact('notes', 'eleves', 'matieres', 'classes'));
    }

    /**
     * Affiche le formulaire de création d'une note
     */
    public function create()
    {
        $eleves = Eleve::orderBy('nom')->orderBy('prenom')->get();
        $matieres = Matiere::orderBy('nom')->get();
        $classes = Classe::orderBy('niveau')->orderBy('nom')->get();
        $professeurs = Professeur::orderBy('nom')->get();
        
        return view('notes.create', compact('eleves', 'matieres', 'classes', 'professeurs'));
    }

    /**
     * Enregistre une nouvelle note
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'eleve_id' => 'required|exists:eleves,id',
            'matiere_id' => 'required|exists:matieres,id',
            'classe_id' => 'required|exists:classes,id',
            'professeur_id' => 'required|exists:professeurs,id',
            'valeur' => 'required|numeric|min:0|max:20',
            'coefficient' => 'required|numeric|min:0.5|max:5',
            'type_evaluation' => 'required|in:Devoir,Interrogation,Composition,Examen,Autre',
            'date_evaluation' => 'required|date',
            'commentaire' => 'nullable|string|max:500',
            'est_eliminatoire' => 'boolean',
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
        
        try {
            Note::create($validated);
            
            return redirect()->route('notes.index')
                            ->with('success', 'Note enregistrée avec succès.');
                            
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Une erreur est survenue lors de l\'enregistrement de la note.');
        }
    }

    /**
     * Affiche les détails d'une note
     */
    public function show(Note $note)
    {
        $note->load(['eleve', 'matiere', 'classe', 'professeur']);
        return view('notes.show', compact('note'));
    }

    /**
     * Affiche le formulaire de modification d'une note
     */
    public function edit(Note $note)
    {
        $eleves = Eleve::orderBy('nom')->orderBy('prenom')->get();
        $matieres = Matiere::orderBy('nom')->get();
        $classes = Classe::orderBy('niveau')->orderBy('nom')->get();
        $professeurs = Professeur::orderBy('nom')->get();
        
        return view('notes.edit', compact('note', 'eleves', 'matieres', 'classes', 'professeurs'));
    }

    /**
     * Met à jour une note existante
     */
    public function update(Request $request, Note $note)
    {
        $validated = $request->validate([
            'eleve_id' => 'required|exists:eleves,id',
            'matiere_id' => 'required|exists:matieres,id',
            'classe_id' => 'required|exists:classes,id',
            'professeur_id' => 'required|exists:professeurs,id',
            'valeur' => 'required|numeric|min:0|max:20',
            'coefficient' => 'required|numeric|min:0.5|max:5',
            'type_evaluation' => 'required|in:Devoir,Interrogation,Composition,Examen,Autre',
            'date_evaluation' => 'required|date',
            'commentaire' => 'nullable|string|max:500',
            'est_eliminatoire' => 'boolean',
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
        
        try {
            $note->update($validated);
            
            return redirect()->route('notes.show', $note->id)
                            ->with('success', 'Note mise à jour avec succès.');
                            
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Une erreur est survenue lors de la mise à jour de la note.');
        }
    }

    /**
     * Supprime une note
     */
    public function destroy(Note $note)
    {
        try {
            $note->delete();
            
            return redirect()->route('notes.index')
                            ->with('success', 'Note supprimée avec succès.');
                            
        } catch (\Exception $e) {
            return back()->with('error', 'Une erreur est survenue lors de la suppression de la note.');
        }
    }
    
    /**
     * Importe des notes à partir d'un fichier Excel
     */
    public function import(Request $request)
    {
        $request->validate([
            'fichier' => 'required|file|mimes:xlsx,xls,csv',
            'matiere_id' => 'required|exists:matieres,id',
            'classe_id' => 'required|exists:classes,id',
            'professeur_id' => 'required|exists:professeurs,id',
            'type_evaluation' => 'required|in:Devoir,Interrogation,Composition,Examen,Autre',
            'date_evaluation' => 'required|date',
            'coefficient' => 'required|numeric|min:0.5|max:5',
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
            
            // Vérifier le format du fichier (au moins 2 colonnes: identifiant_eleve, note)
            if (count($data) < 2 || count($data[0]) < 2) {
                return back()->with('error', 'Format de fichier invalide. Le fichier doit contenir au moins 2 colonnes : identifiant de l\'élève et note.');
            }
            
            // En-têtes de colonnes
            $headers = array_shift($data);
            $idIndex = array_search('identifiant', array_map('strtolower', $headers));
            $noteIndex = array_search('note', array_map('strtolower', $headers));
            
            if ($idIndex === false || $noteIndex === false) {
                return back()->with('error', 'Format de fichier invalide. Les colonnes doivent s\'appeler "identifiant" et "note".');
            }
            
            DB::beginTransaction();
            
            $imported = 0;
            $errors = [];
            
            foreach ($data as $index => $row) {
                $identifiant = trim($row[$idIndex]);
                $valeur = str_replace(',', '.', $row[$noteIndex]); // Gérer les virgules décimales
                
                // Valider la note
                if (!is_numeric($valeur) || $valeur < 0 || $valeur > 20) {
                    $errors[] = "Ligne " . ($index + 2) . ": La note doit être un nombre entre 0 et 20.";
                    continue;
                }
                
                // Trouver l'élève par son identifiant (matricule ou email)
                $eleve = Eleve::where('matricule', $identifiant)
                             ->orWhere('email', $identifiant)
                             ->where('classe_id', $request->classe_id)
                             ->first();
                
                if (!$eleve) {
                    $errors[] = "Ligne " . ($index + 2) . ": Aucun élève trouvé avec l'identifiant " . $identifiant . " dans cette classe.";
                    continue;
                }
                
                // Vérifier si une note existe déjà pour cet élève, cette matière et cette date
                $existingNote = Note::where('eleve_id', $eleve->id)
                                   ->where('matiere_id', $request->matiere_id)
                                   ->where('classe_id', $request->classe_id)
                                   ->where('date_evaluation', $request->date_evaluation)
                                   ->first();
                
                if ($existingNote) {
                    // Mettre à jour la note existante
                    $existingNote->update([
                        'valeur' => $valeur,
                        'coefficient' => $request->coefficient,
                        'type_evaluation' => $request->type_evaluation,
                        'professeur_id' => $request->professeur_id,
                        'commentaire' => 'Importé le ' . now()->format('d/m/Y'),
                    ]);
                } else {
                    // Créer une nouvelle note
                    Note::create([
                        'eleve_id' => $eleve->id,
                        'matiere_id' => $request->matiere_id,
                        'classe_id' => $request->classe_id,
                        'professeur_id' => $request->professeur_id,
                        'valeur' => $valeur,
                        'coefficient' => $request->coefficient,
                        'type_evaluation' => $request->type_evaluation,
                        'date_evaluation' => $request->date_evaluation,
                        'commentaire' => 'Importé le ' . now()->format('d/m/Y'),
                        'est_eliminatoire' => $valeur < 5, // Note éliminatoire si < 5/20
                    ]);
                }
                
                $imported++;
            }
            
            DB::commit();
            
            $message = $imported . ' note(s) importée(s) avec succès.';
            
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
     * Affiche le formulaire d'import de notes
     */
    public function showImportForm()
    {
        $matieres = Matiere::orderBy('nom')->get();
        $classes = Classe::orderBy('niveau')->orderBy('nom')->get();
        $professeurs = Professeur::orderBy('nom')->get();
        
        return view('notes.import', compact('matieres', 'classes', 'professeurs'));
    }
    
    /**
     * Exporte les notes au format Excel
     */
    public function export(Request $request)
    {
        $request->validate([
            'matiere_id' => 'required|exists:matieres,id',
            'classe_id' => 'required|exists:classes,id',
            'date_debut' => 'nullable|date',
            'date_fin' => 'nullable|date|after_or_equal:date_debut',
        ]);
        
        $query = Note::with(['eleve', 'matiere', 'classe', 'professeur'])
                    ->where('matiere_id', $request->matiere_id)
                    ->where('classe_id', $request->classe_id);
        
        if ($request->has('date_debut') && !empty($request->date_debut)) {
            $query->where('date_evaluation', '>=', $request->date_debut);
        }
        
        if ($request->has('date_fin') && !empty($request->date_fin)) {
            $query->where('date_evaluation', '<=', $request->date_fin);
        }
        
        $notes = $query->orderBy('eleve_id')->orderBy('date_evaluation')->get();
        
        if ($notes->isEmpty()) {
            return back()->with('error', 'Aucune note trouvée avec les critères sélectionnés.');
        }
        
        try {
            $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            
            // En-têtes
            $sheet->setCellValue('A1', 'Élève');
            $sheet->setCellValue('B1', 'Date évaluation');
            $sheet->setCellValue('C1', 'Type d\'évaluation');
            $sheet->setCellValue('D1', 'Note/20');
            $sheet->setCellValue('E1', 'Coefficient');
            $sheet->setCellValue('F1', 'Note pondérée');
            $sheet->setCellValue('G1', 'Professeur');
            $sheet->setCellValue('H1', 'Commentaire');
            
            // Style des en-têtes
            $headerStyle = [
                'font' => ['bold' => true],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'E0E0E0']
                ]
            ];
            
            $sheet->getStyle('A1:H1')->applyFromArray($headerStyle);
            
            // Données
            $row = 2;
            
            foreach ($notes as $note) {
                $sheet->setCellValue('A' . $row, $note->eleve->nom_complet);
                $sheet->setCellValue('B' . $row, $note->date_evaluation->format('d/m/Y'));
                $sheet->setCellValue('C' . $row, $note->type_evaluation);
                $sheet->setCellValue('D' . $row, $note->valeur);
                $sheet->setCellValue('E' . $row, $note->coefficient);
                $sheet->setCellValue('F' . $row, '=D' . $row . '*E' . $row);
                $sheet->setCellValue('G' . $row, $note->professeur->nom_complet);
                $sheet->setCellValue('H' . $row, $note->commentaire);
                
                // Mise en forme conditionnelle pour les notes éliminatoires
                if ($note->est_eliminatoire) {
                    $sheet->getStyle('A' . $row . ':H' . $row)->applyFromArray([
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
            foreach (range('A', 'H') as $col) {
                $sheet->getColumnDimension($col)->setAutoSize(true);
            }
            
            // Ajout d'un tableau de synthèse
            $sheet->setCellValue('J1', 'Synthèse');
            $sheet->setCellValue('J2', 'Moyenne de la classe:');
            $sheet->setCellValue('K2', '=AVERAGE(D2:D' . ($row - 1) . ')');
            
            $sheet->setCellValue('J3', 'Note minimale:');
            $sheet->setCellValue('K3', '=MIN(D2:D' . ($row - 1) . ')');
            
            $sheet->setCellValue('J4', 'Note maximale:');
            $sheet->setCellValue('K4', '=MAX(D2:D' . ($row - 1) . ')');
            
            $sheet->setCellValue('J5', 'Taux de réussite:');
            $sheet->setCellValue('K5', '=COUNTIF(D2:D' . ($row - 1) . ',">=10")/COUNT(D2:D' . ($row - 1) . ')');
            $sheet->getStyle('K5')->getNumberFormat()->setFormatCode('0.00%');
            
            // Style de la synthèse
            $sheet->getStyle('J1:K5')->applyFromArray([
                'font' => ['bold' => true],
                'borders' => [
                    'allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                ],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'F5F5F5']
                ]
            ]);
            
            $sheet->getStyle('K2:K4')->getNumberFormat()->setFormatCode('0.00');
            
            // Ajout d'un graphique
            $labels = [
                new \PhpOffice\PhpSpreadsheet\Chart\DataSeriesValues('String', 'Synthèse!$J$2', null, 1),
            ];
            
            $xAxisTickValues = [
                new \PhpOffice\PhpSpreadsheet\Chart\DataSeriesValues('String', 'Synthèse!$K$2:$K$4', null, 3),
            ];
            
            $dataSeriesValues = [
                new \PhpOffice\PhpSpreadsheet\Chart\DataSeriesValues('Number', 'Synthèse!$K$2:$K$4', null, 3),
            ];
            
            $series = new \PhpOffice\PhpSpreadsheet\Chart\DataSeries(
                \PhpOffice\PhpSpreadsheet\Chart\DataSeries::TYPE_BARCHART,
                \PhpOffice\PhpSpreadsheet\Chart\DataSeries::GROUPING_STANDARD,
                range(0, count($dataSeriesValues) - 1),
                $labels,
                $xAxisTickValues,
                $dataSeriesValues
            );
            
            $plotArea = new \PhpOffice\PhpSpreadsheet\Chart\PlotArea(null, [$series]);
            $legend = new \PhpOffice\PhpSpreadsheet\Chart\Legend(\PhpOffice\PhpSpreadsheet\Chart\Legend::POSITION_RIGHT, null, false);
            $title = new \PhpOffice\PhpSpreadsheet\Chart\Title('Statistiques des notes');
            
            $chart = new \PhpOffice\PhpSpreadsheet\Chart(
                'chart1',
                $title,
                $legend,
                $plotArea,
                true,
                0,
                null,
                null
            );
            
            $chart->setTopLeftPosition('J7');
            $chart->setBottomRightPosition('P25');
            $sheet->addChart($chart);
            
            // Enregistrement du fichier
            $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
            $writer->setIncludeCharts(true);
            
            $fileName = 'notes_export_' . date('Y-m-d_His') . '.xlsx';
            $tempFile = tempnam(sys_get_temp_dir(), $fileName);
            $writer->save($tempFile);
            
            return response()->download($tempFile, $fileName)->deleteFileAfterSend(true);
            
        } catch (\Exception $e) {
            return back()->with('error', 'Une erreur est survenue lors de l\'exportation des notes: ' . $e->getMessage());
        }
    }
}
