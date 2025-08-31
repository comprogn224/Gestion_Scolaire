@extends('layouts.app')

@section('title', 'Tableau de bord - Administrateur')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Tableau de bord Administrateur</h5>
                </div>

                <div class="card-body">
                    <div class="alert alert-success" role="alert">
                        <h4 class="alert-heading">Bienvenue, {{ Auth::user()->name }} !</h4>
                        <p>Vous êtes connecté en tant qu'<strong>Administrateur</strong>.</p>
                        <hr>
                        <p class="mb-0">Accédez à toutes les fonctionnalités du système depuis ce tableau de bord.</p>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-4 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Utilisateurs</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ App\Models\User::count() }}</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-users fa-2x text-gray-300"></i>
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
                                                Classes</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ App\Models\Classe::count() }}</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-chalkboard-teacher fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 mb-4">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                                Élèves</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ App\Models\Eleve::count() }}</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-user-graduate fa-2x text-gray-300"></i>
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
</div>
@endsection
