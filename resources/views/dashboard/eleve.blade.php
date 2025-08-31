@extends('layouts.app')

@section('title', 'Tableau de bord - Élève')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">Tableau de bord Élève</h5>
                </div>

                <div class="card-body">
                    <div class="alert alert-info" role="alert">
                        <h4 class="alert-heading">Bienvenue, {{ Auth::user()->name }} !</h4>
                        <p>Vous êtes connecté en tant qu'<strong>Élève</strong>.</p>
                        <hr>
                        <p class="mb-0">Consultez votre emploi du temps, vos notes et vos devoirs.</p>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-4 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Moyenne générale</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format(rand(10, 18) + (rand(0, 9) / 10), 1) }}/20</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-chart-line fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Prochain cours</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">Mathématiques</div>
                                            <small>Demain, 8h00</small>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-book fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                Devoirs à rendre</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ rand(0, 5) }}</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-tasks fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5 class="mb-0">Prochains cours</h5>
                                </div>
                                <div class="card-body p-0">
                                    <div class="list-group list-group-flush">
                                        @for($i = 1; $i <= 3; $i++)
                                        <div class="list-group-item">
                                            <div class="d-flex w-100 justify-content-between">
                                                <h6 class="mb-1">Matière {{ $i }}</h6>
                                                <small class="text-muted">{{ now()->addDays($i)->format('d/m/Y') }}</small>
                                            </div>
                                            <p class="mb-1">08:00 - 10:00 | Salle {{ 100 + $i }}</p>
                                            <small class="text-muted">Professeur Nom {{ $i }}</small>
                                        </div>
                                        @endfor
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mb-0">Dernières notes</h5>
                                </div>
                                <div class="card-body p-0">
                                    <div class="list-group list-group-flush">
                                        @php
                                            $matieres = ['Mathématiques', 'Français', 'Histoire', 'SVT', 'Physique'];
                                            $dates = [now()->subDays(2), now()->subDays(5), now()->subDays(7)];
                                        @endphp
                                        @for($i = 0; $i < 3; $i++)
                                        <div class="list-group-item">
                                            <div class="d-flex w-100 justify-content-between">
                                                <h6 class="mb-1">{{ $matieres[$i] }}</h6>
                                                <span class="badge bg-{{ rand(10, 18) >= 10 ? 'success' : 'danger' }} rounded-pill">
                                                    {{ rand(10, 18) }}/20
                                                </span>
                                            </div>
                                            <p class="mb-1">Devoir {{ $i + 1 }}</p>
                                            <small class="text-muted">{{ $dates[$i]->format('d/m/Y') }}</small>
                                        </div>
                                        @endfor
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
