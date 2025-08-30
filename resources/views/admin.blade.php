@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <div class="row">
    <!-- Sidebar -->
    <nav class="col-md-3 col-lg-2 d-md-block bg-white sidebar p-3 border-end">
      <h4 class="fw-bold mb-4"><i class="bi bi-mortarboard"></i> EduManager</h4>
      <ul class="nav flex-column">
        <li class="nav-item mb-2">
          <a class="nav-link active" href="{{ route('admin') }}"><i class="bi bi-grid"></i> Tableau de bord</a>
        </li>
        <li class="nav-item mb-2">
          <a class="nav-link" href="{{ route('eleve') }}"><i class="bi bi-people"></i> Élèves</a>
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
          <div class="rounded-circle bg-secondary text-white d-flex justify-content-center align-items-center me-2" style="width:35px;height:35px;">A</div>
          <div>
            <strong>Administrateur Principal</strong><br>
            <small class="text-muted">Admin</small>
          </div>
        </div>
      </div>
    </nav>

    <!-- Content -->
    <main class="col-md-9 ms-sm-auto col-lg-10 p-4">
      <!-- Top Bar -->
      <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>Bonsoir, <span class="fw-bold">Administrateur Principal</span></h3>
        <div class="d-flex align-items-center">
          <i class="bi bi-bell fs-4 me-3 position-relative">
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">3</span>
          </i>
          <div class="d-flex align-items-center">
            <div class="rounded-circle bg-primary text-white d-flex justify-content-center align-items-center me-2" style="width:35px;height:35px;">A</div>
            <span>Admin</span>
          </div>
        </div>
      </div>

      <p class="text-muted">Voici un aperçu de votre espace administrateur.</p>

      <!-- Stats Cards -->
      <div class="row mb-4">
        <div class="col-md-3">
          <div class="card p-3 shadow-sm">
            <h6>Élèves</h6>
            <h3>1,234</h3>
            <small class="text-success">+12% ce mois</small>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card p-3 shadow-sm">
            <h6>Professeurs</h6>
            <h3>89</h3>
            <small>5 nouveaux</small>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card p-3 shadow-sm">
            <h6>Classes</h6>
            <h3>45</h3>
            <small>12 niveaux</small>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card p-3 shadow-sm">
            <h6>Absences</h6>
            <h3>23</h3>
            <small>Aujourd'hui</small>
          </div>
        </div>
      </div>

      <!-- Recent Activities & Upcoming -->
      <div class="row">
        <div class="col-md-6">
          <div class="card p-3 shadow-sm">
            <h6 class="fw-bold">Activités récentes</h6>
            <ul class="mt-3">
              <li class="text-primary">Nouvel élève inscrit : Marie Dupont</li>
              <li class="text-danger">Classe 6ème A créée</li>
              <li class="text-warning">Rapport mensuel généré</li>
            </ul>
          </div>
        </div>
        <div class="col-md-6">
          <div class="card p-3 shadow-sm">
            <h6 class="fw-bold">Prochaines échéances</h6>
            <ul class="mt-3">
              <li>Conseil de classe 3ème <span class="text-muted">Demain</span></li>
              <li>Réunion parents-professeurs <span class="text-muted">Vendredi</span></li>
              <li>Rapport trimestriel <span class="text-muted">15 Mars</span></li>
            </ul>
          </div>
        </div>
      </div>
    </main>
  </div>
</div>
@endsection
