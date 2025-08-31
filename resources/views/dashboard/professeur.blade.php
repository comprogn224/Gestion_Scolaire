@extends('layouts.app')

@section('title', 'Tableau de bord - Professeur')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">Tableau de bord Professeur</h5>
                </div>

                <div class="card-body">
                    <div class="alert alert-success" role="alert">
                        <h4 class="alert-heading">Bienvenue, {{ Auth::user()->name }} !</h4>
                        <p>Vous êtes connecté en tant que <strong>Professeur</strong>.</p>
                        <hr>
                        <p class="mb-0">Accédez à vos cours, élèves et évaluations depuis ce tableau de bord.</p>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Mes classes</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ rand(1, 5) }}</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-chalkboard-teacher fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 mb-4">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                                Élèves à ma charge</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ rand(20, 100) }}</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-user-graduate fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mt-4">
                        <div class="card-header">
                            <h5 class="mb-0">Prochains cours</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Heure</th>
                                            <th>Classe</th>
                                            <th>Matière</th>
                                            <th>Salle</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @for($i = 1; $i <= 3; $i++)
                                        <tr>
                                            <td>{{ now()->addDays($i)->format('d/m/Y') }}</td>
                                            <td>08:00 - 10:00</td>
                                            <td>Classe {{ chr(64 + $i) }}</td>
                                            <td>Matière {{ $i }}</td>
                                            <td>Salle {{ 100 + $i }}</td>
                                        </tr>
                                        @endfor
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
