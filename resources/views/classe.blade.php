@extends('layouts.app')

@section('title', 'Gestion des classes')

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .class-card {
            transition: transform 0.2s, box-shadow 0.2s;
            margin-bottom: 1.5rem;
        }
        .class-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
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
                    <a class="nav-link" href="{{ route('eleve') }}"><i class="bi bi-people"></i> Élèves</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="{{ route('professeur') }}"><i class="bi bi-person-badge"></i> Professeurs</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link active" href="{{ route('classe') }}"><i class="bi bi-building"></i> Classes</a>
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
                    <h1 class="h2">Gestion des classes</h1>
                    <p class="text-muted">Créez, modifiez et organisez les classes de l’établissement.</p>
                </div>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <button class="btn btn-primary">
                        <i class="bi bi-plus-circle"></i> Ajouter une classe
                    </button>
                </div>
            </div>

            <!-- Filters -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                        <input type="text" class="form-control" placeholder="Rechercher une classe...">
                    </div>
                </div>
                <div class="col-md-4">
                    <select class="form-select">
                        <option value="">Tous les niveaux</option>
                        <option value="primaire">Primaire</option>
                        <option value="college">Collège</option>
                        <option value="lycee">Lycée</option>
                    </select>
                </div>
            </div>

            <!-- Classes Count -->
            <div class="alert alert-info mb-4">
                <i class="bi bi-info-circle"></i> 3 classe(s) trouvée(s)
            </div>

            <!-- Grid View -->
            <div class="row">
                <!-- Classe 1 -->
                <div class="col-md-4 mb-4">
                    <div class="card class-card h-100">
                        <div class="card-body">
                            <h5 class="card-title"><i class="bi bi-building"></i> 6ème A</h5>
                            <p class="card-text">
                                <strong>Prof principal :</strong> Mr. Dupont<br>
                                <strong>Élèves :</strong> 35
                            </p>
                        </div>
                        <div class="card-footer bg-transparent">
                            <div class="d-flex justify-content-between">
                                <button class="btn btn-sm btn-outline-primary"><i class="bi bi-eye"></i></button>
                                <button class="btn btn-sm btn-outline-warning"><i class="bi bi-pencil"></i></button>
                                <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Classe 2 -->
                <div class="col-md-4 mb-4">
                    <div class="card class-card h-100">
                        <div class="card-body">
                            <h5 class="card-title"><i class="bi bi-building"></i> 5ème B</h5>
                            <p class="card-text">
                                <strong>Prof principal :</strong> Mme. Martin<br>
                                <strong>Élèves :</strong> 32
                            </p>
                        </div>
                        <div class="card-footer bg-transparent">
                            <div class="d-flex justify-content-between">
                                <button class="btn btn-sm btn-outline-primary"><i class="bi bi-eye"></i></button>
                                <button class="btn btn-sm btn-outline-warning"><i class="bi bi-pencil"></i></button>
                                <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Classe 3 -->
                <div class="col-md-4 mb-4">
                    <div class="card class-card h-100">
                        <div class="card-body">
                            <h5 class="card-title"><i class="bi bi-building"></i> Terminale S</h5>
                            <p class="card-text">
                                <strong>Prof principal :</strong> Mme. Diallo<br>
                                <strong>Élèves :</strong> 28
                            </p>
                        </div>
                        <div class="card-footer bg-transparent">
                            <div class="d-flex justify-content-between">
                                <button class="btn btn-sm btn-outline-primary"><i class="bi bi-eye"></i></button>
                                <button class="btn btn-sm btn-outline-warning"><i class="bi bi-pencil"></i></button>
                                <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
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
