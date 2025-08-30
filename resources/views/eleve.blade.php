@extends('layouts.app')

@section('title', 'Gestion des élèves')

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .student-card {
            transition: transform 0.2s, box-shadow 0.2s;
            margin-bottom: 1.5rem;
        }
        .student-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }
        .student-avatar {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 50%;
            border: 3px solid #fff;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }
        .action-buttons .btn {
            margin-right: 5px;
        }
        .view-toggle {
            cursor: pointer;
            padding: 5px 10px;
            border-radius: 4px;
        }
        .view-toggle.active {
            background-color: #0d6efd;
            color: white;
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
                <li class="nav-item mb-2">
                    <a class="nav-link" href="{{ route('admin') }}"><i class="bi bi-grid"></i> Tableau de bord</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link active" href="{{ route('eleve') }}"><i class="bi bi-people"></i> Élèves</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="{{ route('professeur') }}"><i class="bi bi-person-badge"></i> Professeurs</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="{{ route('classe') }}"><i class="bi bi-building"></i> Classes</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="{{ route('matiere') }}"><i class="bi bi-book"></i> Matières</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="{{ route('note') }}"><i class="bi bi-journal-check"></i> Notes</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="{{ route('absence') }}"><i class="bi bi-calendar-x"></i> Absences</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="{{ route('parametre') }}"><i class="bi bi-gear"></i> Paramètres</a>
                </li>
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
            <!-- Top Bar -->
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-4 border-bottom">
                <div>
                    <h1 class="h2">Gestion des élèves</h1>
                    <p class="text-muted">Gérez les informations des élèves de votre établissement.</p>
                </div>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <button class="btn btn-primary">
                        <i class="bi bi-plus-circle"></i> Ajouter un élève
                    </button>
                </div>
            </div>

            <!-- Filters -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                        <input type="text" class="form-control" placeholder="Rechercher un élève...">
                    </div>
                </div>
                <div class="col-md-4">
                    <select class="form-select">
                        <option value="">Toutes les classes</option>
                        <option value="A">Classe A</option>
                        <option value="B">Classe B</option>
                        <option value="C">Classe C</option>
                        <option value="D">Classe D</option>
                    </select>
                </div>
                <div class="col-md-2 d-flex justify-content-end">
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-outline-secondary view-toggle active" data-view="grid">
                            <i class="bi bi-grid"></i>
                        </button>
                        <button type="button" class="btn btn-outline-secondary view-toggle" data-view="list">
                            <i class="bi bi-list-ul"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Students Count -->
            <div class="alert alert-info mb-4">
                <i class="bi bi-info-circle"></i> 3 élève(s) trouvé(s)
            </div>

            <!-- Grid View -->
            <div id="grid-view">
                <div class="row">
                    <!-- Student Card 1 -->
                    <div class="col-md-4 mb-4">
                        <div class="card student-card h-100">
                            <div class="card-body text-center">
                                <img src="https://via.placeholder.com/80" alt="Photo de l'élève" class="student-avatar mb-3">
                                <h5 class="card-title">John Doe</h5>
                                <h6 class="card-subtitle mb-2 text-muted">Classe A</h6>
                                <p class="card-text">
                                    <i class="bi bi-envelope"></i> john.doe@example.com<br>
                                    <i class="bi bi-telephone"></i> 06 12 34 56 78
                                </p>
                                <div class="action-buttons">
                                    <button class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-eye"></i> Voir
                                    </button>
                                    <button class="btn btn-sm btn-outline-warning">
                                        <i class="bi bi-pencil"></i> Modifier
                                    </button>
                                    <button class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-footer bg-transparent">
                                <small class="text-muted">
                                    <i class="bi bi-people"></i> Parents : Pierre et Marie Martin
                                </small>
                            </div>
                        </div>
                    </div>

                    <!-- Student Card 2 -->
                    <div class="col-md-4 mb-4">
                        <div class="card student-card h-100">
                            <div class="card-body text-center">
                                <img src="https://via.placeholder.com/80" alt="Photo de l'élève" class="student-avatar mb-3">
                                <h5 class="card-title">Jane Smith</h5>
                                <h6 class="card-subtitle mb-2 text-muted">Classe B</h6>
                                <p class="card-text">
                                    <i class="bi bi-envelope"></i> jane.smith@example.com<br>
                                    <i class="bi bi-telephone"></i> 06 23 45 67 89
                                </p>
                                <div class="action-buttons">
                                    <button class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-eye"></i> Voir
                                    </button>
                                    <button class="btn btn-sm btn-outline-warning">
                                        <i class="bi bi-pencil"></i> Modifier
                                    </button>
                                    <button class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-footer bg-transparent">
                                <small class="text-muted">
                                    <i class="bi bi-people"></i> Parents : Jean et Sophie Dupont
                                </small>
                            </div>
                        </div>
                    </div>

                    <!-- Student Card 3 -->
                    <div class="col-md-4 mb-4">
                        <div class="card student-card h-100">
                            <div class="card-body text-center">
                                <img src="https://via.placeholder.com/80" alt="Photo de l'élève" class="student-avatar mb-3">
                                <h5 class="card-title">Mohamed Ali</h5>
                                <h6 class="card-subtitle mb-2 text-muted">Classe A</h6>
                                <p class="card-text">
                                    <i class="bi bi-envelope"></i> mohamed.ali@example.com<br>
                                    <i class="bi bi-telephone"></i> 06 34 56 78 90
                                </p>
                                <div class="action-buttons">
                                    <button class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-eye"></i> Voir
                                    </button>
                                    <button class="btn btn-sm btn-outline-warning">
                                        <i class="bi bi-pencil"></i> Modifier
                                    </button>
                                    <button class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-footer bg-transparent">
                                <small class="text-muted">
                                    <i class="bi bi-people"></i> Parents : Karim et Leila Ali
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Table View (Hidden by default) -->
            <div id="table-view" style="display: none;">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Photo</th>
                                <th>Nom</th>
                                <th>Email</th>
                                <th>Classe</th>
                                <th>Téléphone</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <img src="https://via.placeholder.com/40" alt="Photo" class="rounded-circle" width="40" height="40">
                                </td>
                                <td>John Doe</td>
                                <td>john.doe@example.com</td>
                                <td>Classe A</td>
                                <td>06 12 34 56 78</td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <button class="btn btn-outline-primary" title="Voir">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                        <button class="btn btn-outline-warning" title="Modifier">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button class="btn btn-outline-danger" title="Supprimer">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <img src="https://via.placeholder.com/40" alt="Photo" class="rounded-circle" width="40" height="40">
                                </td>
                                <td>Jane Smith</td>
                                <td>jane.smith@example.com</td>
                                <td>Classe B</td>
                                <td>06 23 45 67 89</td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <button class="btn btn-outline-primary" title="Voir">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                        <button class="btn btn-outline-warning" title="Modifier">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button class="btn btn-outline-danger" title="Supprimer">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <img src="https://via.placeholder.com/40" alt="Photo" class="rounded-circle" width="40" height="40">
                                </td>
                                <td>Mohamed Ali</td>
                                <td>mohamed.ali@example.com</td>
                                <td>Classe A</td>
                                <td>06 34 56 78 90</td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <button class="btn btn-outline-primary" title="Voir">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                        <button class="btn btn-outline-warning" title="Modifier">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button class="btn btn-outline-danger" title="Supprimer">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Pagination -->
            <nav aria-label="Page navigation" class="mt-4">
                <ul class="pagination justify-content-center">
                    <li class="page-item disabled">
                        <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Précédent</a>
                    </li>
                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item">
                        <a class="page-link" href="#">Suivant</a>
                    </li>
                </ul>
            </nav>
        </main>
    </div>
</div>

@push('scripts')
<script>
    // Toggle between grid and list view
    document.addEventListener('DOMContentLoaded', function() {
        const gridView = document.getElementById('grid-view');
        const tableView = document.getElementById('table-view');
        const viewToggles = document.querySelectorAll('.view-toggle');

        viewToggles.forEach(toggle => {
            toggle.addEventListener('click', function() {
                const view = this.getAttribute('data-view');
                
                // Update active state
                viewToggles.forEach(t => t.classList.remove('active'));
                this.classList.add('active');
                
                // Show/hide views
                if (view === 'grid') {
                    gridView.style.display = 'block';
                    tableView.style.display = 'none';
                } else {
                    gridView.style.display = 'none';
                    tableView.style.display = 'block';
                }
            });
        });
    });
</script>
@endpush
@endsection
