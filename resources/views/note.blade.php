@extends('layouts.app')

@section('title', 'Gestion des notes')

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .note-card {
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .note-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 0.4rem 0.8rem rgba(0, 0, 0, 0.1);
        }
        .note-badge {
            font-size: 1.1rem;
            padding: 0.4rem 0.8rem;
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
                <li class="nav-item mb-2"><a class="nav-link active" href="{{ route('note') }}"><i class="bi bi-journal-check"></i> Notes</a></li>
                <li class="nav-item mb-2"><a class="nav-link" href="{{ route('absence') }}"><i class="bi bi-calendar-x"></i> Absences</a></li>
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
                    <h1 class="h2">Gestion des notes</h1>
                    <p class="text-muted">Ajoutez, modifiez et visualisez les notes des élèves.</p>
                </div>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <button class="btn btn-primary"><i class="bi bi-plus-circle"></i> Ajouter une note</button>
                </div>
            </div>

            <!-- Filters -->
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                        <input type="text" class="form-control" placeholder="Rechercher par élève...">
                    </div>
                </div>
                <div class="col-md-4">
                    <select class="form-select">
                        <option value="">Toutes les matières</option>
                        <option>Mathématiques</option>
                        <option>Français</option>
                        <option>Physique-Chimie</option>
                        <option>Anglais</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <select class="form-select">
                        <option value="">Toutes les classes</option>
                        <option>6ème A</option>
                        <option>5ème B</option>
                        <option>Terminale C</option>
                    </select>
                </div>
            </div>

            <!-- Notes Table -->
            <div class="table-responsive shadow-sm rounded">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Élève</th>
                            <th>Classe</th>
                            <th>Matière</th>
                            <th>Note</th>
                            <th>Professeur</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Note 1 -->
                        <tr>
                            <td>Fatou Diallo</td>
                            <td>Terminale C</td>
                            <td>Mathématiques</td>
                            <td><span class="badge bg-success note-badge">16 / 20</span></td>
                            <td>Mr. Diallo</td>
                            <td>28-08-2025</td>
                            <td>
                                <button class="btn btn-sm btn-outline-primary"><i class="bi bi-eye"></i></button>
                                <button class="btn btn-sm btn-outline-warning"><i class="bi bi-pencil"></i></button>
                                <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </td>
                        </tr>
                        <!-- Note 2 -->
                        <tr>
                            <td>Mamadou Camara</td>
                            <td>5ème B</td>
                            <td>Français</td>
                            <td><span class="badge bg-warning text-dark note-badge">10 / 20</span></td>
                            <td>Mme. Konaté</td>
                            <td>27-08-2025</td>
                            <td>
                                <button class="btn btn-sm btn-outline-primary"><i class="bi bi-eye"></i></button>
                                <button class="btn btn-sm btn-outline-warning"><i class="bi bi-pencil"></i></button>
                                <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </td>
                        </tr>
                        <!-- Note 3 -->
                        <tr>
                            <td>Aminata Bah</td>
                            <td>6ème A</td>
                            <td>Anglais</td>
                            <td><span class="badge bg-danger note-badge">7 / 20</span></td>
                            <td>Mme. Camara</td>
                            <td>26-08-2025</td>
                            <td>
                                <button class="btn btn-sm btn-outline-primary"><i class="bi bi-eye"></i></button>
                                <button class="btn btn-sm btn-outline-warning"><i class="bi bi-pencil"></i></button>
                                <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <nav aria-label="Page navigation" class="mt-4">
                <ul class="pagination justify-content-center">
                    <li class="page-item disabled"><a class="page-link" href="#">Précédent</a></li>
                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item"><a class="page-link" href="#">Suivant</a></li>
                </ul>
            </nav>
        </main>
    </div>
</div>
@endsection
