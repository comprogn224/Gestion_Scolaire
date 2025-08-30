@extends('layouts.app')

@section('title', 'Paramètres')

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .settings-card {
            border-radius: 0.75rem;
            transition: all 0.2s ease-in-out;
        }
        .settings-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
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
                <li class="nav-item mb-2"><a class="nav-link" href="{{ route('absence') }}"><i class="bi bi-calendar-x"></i> Absences</a></li>
                <li class="nav-item mb-2"><a class="nav-link active" href="{{ route('parametre') }}"><i class="bi bi-gear"></i> Paramètres</a></li>
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
                    <h1 class="h2">Paramètres</h1>
                    <p class="text-muted">Gérez vos informations personnelles, sécurité et préférences.</p>
                </div>
            </div>

            <!-- Paramètres Cards -->
            <div class="row g-4">
                <!-- Profil -->
                <div class="col-md-6">
                    <div class="card settings-card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title"><i class="bi bi-person-circle"></i> Profil</h5>
                            <p class="card-text text-muted">Modifier votre nom, email et photo de profil.</p>
                            <button class="btn btn-outline-primary"><i class="bi bi-pencil"></i> Modifier</button>
                        </div>
                    </div>
                </div>

                <!-- Sécurité -->
                <div class="col-md-6">
                    <div class="card settings-card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title"><i class="bi bi-shield-lock"></i> Sécurité</h5>
                            <p class="card-text text-muted">Changer votre mot de passe et activer la double authentification.</p>
                            <button class="btn btn-outline-warning"><i class="bi bi-key"></i> Mettre à jour</button>
                        </div>
                    </div>
                </div>

                <!-- Préférences -->
                <div class="col-md-6">
                    <div class="card settings-card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title"><i class="bi bi-sliders"></i> Préférences</h5>
                            <p class="card-text text-muted">Choisir la langue, thème clair/sombre et notifications.</p>
                            <button class="btn btn-outline-success"><i class="bi bi-gear"></i> Configurer</button>
                        </div>
                    </div>
                </div>

                <!-- Système -->
                <div class="col-md-6">
                    <div class="card settings-card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title"><i class="bi bi-hdd-network"></i> Système</h5>
                            <p class="card-text text-muted">Sauvegarde des données, mise à jour de la base et logs.</p>
                            <button class="btn btn-outline-danger"><i class="bi bi-database"></i> Gérer</button>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
@endsection
