@extends('layouts.app')

@section('title', 'Gestion des absences')

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <style>
        .absence-badge {
            font-size: 0.95rem;
            padding: 0.35rem 0.7rem;
        }
        .select2-container--default .select2-selection--single {
            height: 38px;
            padding: 5px;
            border: 1px solid #ced4da;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 36px;
        }
        .justificatif-link {
            color: #0d6efd;
            text-decoration: none;
        }
        .justificatif-link:hover {
            text-decoration: underline;
        }
    </style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <nav class="col-md-3 col-lg-2 d-md-block bg-white sidebar p-3 border-end">
            <h4 class="fw-bold mb-4"><i class="bi bi-mortarboard"></i> EduManager</h4>
            <ul class="nav flex-column">
                <li class="nav-item mb-2"><a class="nav-link" href="{{ route('admin') }}"><i class="bi bi-grid"></i> Tableau de bord</a></li>
                <li class="nav-item mb-2"><a class="nav-link" href="{{ route('eleve') }}"><i class="bi bi-people"></i> Élèves</a></li>
                <li class="nav-item mb-2"><a class="nav-link" href="{{ route('professeur') }}"><i class="bi bi-person-badge"></i> Professeurs</a></li>
                <li class="nav-item mb-2"><a class="nav-link" href="{{ route('classe') }}"><i class="bi bi-building"></i> Classes</a></li>
                <li class="nav-item mb-2"><a class="nav-link" href="{{ route('matiere') }}"><i class="bi bi-book"></i> Matières</a></li>
                <li class="nav-item mb-2"><a class="nav-link" href="{{ route('note') }}"><i class="bi bi-journal-check"></i> Notes</a></li>
                <li class="nav-item mb-2"><a class="nav-link active" href="{{ route('absence') }}"><i class="bi bi-calendar-x"></i> Absences</a></li>
                <li class="nav-item mb-2"><a class="nav-link" href="{{ route('parametre') }}"><i class="bi bi-gear"></i> Paramètres</a></li>
            </ul>
            <hr>
            <div class="mt-auto">
                <div class="d-flex align-items-center">
                    <div class="rounded-circle bg-primary text-white d-flex justify-content-center align-items-center me-2" style="width:35px;height:35px;">A</div>
                    <div>
                        <strong>Administrateur</strong><br>
                        <small class="text-muted">Admin</small>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 p-4">
            <!-- Header -->
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-4 border-bottom">
                <div>
                    <h1 class="h2">Gestion des absences</h1>
                    <p class="text-muted">Suivi des absences des élèves par matière et par date.</p>
                </div>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a href="{{ route('absences.create') }}" class="btn btn-primary me-2">
                        <i class="bi bi-plus-circle"></i> Ajouter une absence
                    </a>
                    <a href="{{ route('absences.import') }}" class="btn btn-outline-secondary me-2">
                        <i class="bi bi-upload"></i> Importer
                    </a>
                    <a href="{{ route('absences.export') }}" class="btn btn-outline-success me-2">
                        <i class="bi bi-download"></i> Exporter
                    </a>
                    <a href="{{ route('absences.statistiques') }}" class="btn btn-outline-info">
                        <i class="bi bi-graph-up"></i> Statistiques
                    </a>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Filters -->
            <form action="{{ route('absences.index') }}" method="GET" class="mb-4">
                <div class="row g-3">
                    <div class="col-md-3">
                        <select name="eleve_id" class="form-select select2">
                            <option value="">Tous les élèves</option>
                            @foreach($eleves as $eleve)
                                <option value="{{ $eleve->id }}" {{ request('eleve_id') == $eleve->id ? 'selected' : '' }}>
                                    {{ $eleve->nom }} {{ $eleve->prenom }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select name="matiere_id" class="form-select select2">
                            <option value="">Toutes les matières</option>
                            @foreach($matieres as $matiere)
                                <option value="{{ $matiere->id }}" {{ request('matiere_id') == $matiere->id ? 'selected' : '' }}>
                                    {{ $matiere->nom }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select name="classe_id" class="form-select select2">
                            <option value="">Toutes les classes</option>
                            @foreach($classes as $classe)
                                <option value="{{ $classe->id }}" {{ request('classe_id') == $classe->id ? 'selected' : '' }}>
                                    {{ $classe->niveau }} - {{ $classe->nom }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select name="justifiee" class="form-select">
                            <option value="">Tous les statuts</option>
                            <option value="1" {{ request('justifiee') === '1' ? 'selected' : '' }}>Justifiées</option>
                            <option value="0" {{ request('justifiee') === '0' ? 'selected' : '' }}>Non justifiées</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <div class="input-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-funnel"></i> Filtrer
                            </button>
                            <a href="{{ route('absences.index') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-counterclockwise"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-3">
                        <input type="date" name="date_debut" class="form-control" value="{{ request('date_debut') }}" placeholder="Date de début">
                    </div>
                    <div class="col-md-3">
                        <input type="date" name="date_fin" class="form-control" value="{{ request('date_fin') }}" placeholder="Date de fin">
                    </div>
                </div>
            </form>

            <!-- Absences Table -->
            @if($absences->isEmpty())
                <div class="alert alert-info">
                    Aucune absence trouvée avec les critères de recherche sélectionnés.
                </div>
            @else
                <div class="table-responsive shadow-sm rounded">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Élève</th>
                                <th>Classe</th>
                                <th>Matière</th>
                                <th>Date</th>
                                <th>Créneau</th>
                                <th>Statut</th>
                                <th>Justificatif</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($absences as $absence)
                                <tr>
                                    <td>{{ $absence->eleve->nom }} {{ $absence->eleve->prenom }}</td>
                                    <td>{{ $absence->classe->niveau }} - {{ $absence->classe->nom }}</td>
                                    <td>{{ $absence->matiere->nom }}</td>
                                    <td>{{ \Carbon\Carbon::parse($absence->date)->format('d/m/Y') }}</td>
                                    <td>{{ $absence->heure_debut }} - {{ $absence->heure_fin }}</td>
                                    <td>
                                        @if($absence->est_justifiee)
                                            <span class="badge bg-success absence-badge">Justifiée</span>
                                        @else
                                            <span class="badge bg-danger absence-badge">Non justifiée</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($absence->chemin_justificatif)
                                            <a href="{{ route('absences.justificatif', $absence) }}" class="justificatif-link" target="_blank">
                                                <i class="bi bi-file-earmark-text"></i> Voir
                                            </a>
                                        @else
                                            <span class="text-muted">Aucun</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('absences.show', $absence) }}" class="btn btn-sm btn-outline-primary" title="Voir">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('absences.edit', $absence) }}" class="btn btn-sm btn-outline-warning" title="Modifier">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('absences.destroy', $absence) }}" method="POST" class="d-inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette absence ?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Supprimer">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div class="text-muted">
                        Affichage de {{ $absences->firstItem() }} à {{ $absences->lastItem() }} sur {{ $absences->total() }} absences
                    </div>
                    {{ $absences->withQueryString()->links() }}
                </div>
            @endif
        </main>
    </div>
</div>
@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        $(document).ready(function() {
            // Initialisation de Select2
            $('.select2').select2({
                placeholder: 'Sélectionner...',
                allowClear: true,
                width: '100%'
            });

            // Initialisation de Flatpickr pour les champs de date
            flatpickr("input[type=date]", {
                dateFormat: "Y-m-d",
                locale: "fr"
            });

            // Gestion de la suppression avec confirmation
            $('.btn-delete').on('click', function(e) {
                e.preventDefault();
                if (confirm('Êtes-vous sûr de vouloir supprimer cette absence ?')) {
                    $(this).closest('form').submit();
                }
            });
        });
    </script>
@endpush

@endsection
