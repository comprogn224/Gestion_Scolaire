@extends('layouts.app')

@section('title', 'Accueil - Gestion Scolaire')

@section('content')
<!-- Hero Section -->
<section class="position-relative overflow-hidden p-6 p-lg-8 bg-white text-dark">
    <div class="container">
        <div class="row align-items-center min-vh-60">
            <div class="col-lg-6 pe-lg-6 mb-5 mb-lg-0">
                <h1 class="display-4 fw-bold mb-4">Gérez votre établissement <span class="text-primary">scolaire</span> facilement</h1>
                <p class="lead mb-5">Une plateforme complète pour simplifier la gestion des élèves, des classes et des évaluations. Gagnez du temps et améliorez votre productivité dès aujourd'hui.</p>
                
                <div class="d-flex flex-column flex-sm-row gap-3">
                    <a href="{{ route('register') }}" class="btn btn-primary btn-lg px-4 py-3 fw-medium d-flex align-items-center justify-content-center">
                        <i class="fas fa-user-plus me-2"></i> S'inscrire
                    </a>
                    <a href="#" class="btn btn-outline-primary btn-lg px-4 py-3 fw-medium">
                        <i class="fas fa-play-circle me-2"></i> Voir la démo
                    </a>
                </div>
            </div>
            <div class="col-lg-6 ps-lg-6">
                <div class="position-relative">
                    <div class="position-absolute top-0 start-0 translate-middle bg-white rounded-circle shadow-lg w-100px h-100px z-1"></div>
                    <div class="position-absolute bottom-0 end-0 translate-middle bg-warning rounded-circle w-60 h-60 z-1"></div>
                    <div class="position-relative z-2">
                        <img src="{{ asset('images/imageee.jpg') }}" alt="Tableau de bord Gestion Scolaire" class="img-fluid rounded-4 shadow-lg">
                        <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center z-3">
                            <a href="#" class="btn btn-primary btn-lg rounded-circle p-3 shadow" data-bs-toggle="modal" data-bs-target="#videoModal">
                                <i class="fas fa-play"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Video Modal -->
<div class="modal fade" id="videoModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header border-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <div class="ratio ratio-16x9">
                    <iframe src="https://www.youtube.com/embed/dQw4w9WgXcQ" title="Présentation Gestion Scolaire" allowfullscreen></iframe>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Features Section -->
<section id="features" class="py-5 bg-light">
    <div class="container py-5">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Nos Fonctionnalités Principales</h2>
            <p class="lead text-muted">Découvrez comment notre solution peut vous aider à gérer efficacement votre établissement</p>
        </div>
        
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm hover-shadow">
                    <div class="card-body p-4 text-center">
                        <div class="icon-box bg-primary bg-opacity-10 text-primary rounded-circle mx-auto mb-4">
                            <i class="fas fa-user-graduate fa-2x"></i>
                        </div>
                        <h4 class="h5 fw-bold">Gestion des Élèves</h4>
                        <p class="text-muted">Gérez facilement les dossiers des élèves, les inscriptions et les informations personnelles en temps réel.</p>
                        <a href="#" class="btn btn-link text-decoration-none">En savoir plus →</a>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm hover-shadow transition-all">
                    <div class="card-body p-4 text-center">
                        <div class="icon-box bg-success bg-opacity-10 text-success rounded-circle mx-auto mb-4" style="width: 80px; height: 80px; line-height: 80px;">
                            <i class="fas fa-chalkboard-teacher fa-2x"></i>
                        </div>
                        <h4 class="h5 fw-bold">Gestion des Classes</h4>
                        <p class="text-muted">Organisez vos classes, matières et emplois du temps de manière intuitive et efficace.</p>
                        <a href="#" class="btn btn-link text-decoration-none">En savoir plus →</a>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm hover-shadow transition-all">
                    <div class="card-body p-4 text-center">
                        <div class="icon-box bg-info bg-opacity-10 text-info rounded-circle mx-auto mb-4" style="width: 80px; height: 80px; line-height: 80px;">
                            <i class="fas fa-chart-line fa-2x"></i>
                        </div>
                        <h4 class="h5 fw-bold">Tableaux de Bord</h4>
                        <p class="text-muted">Accédez à des statistiques détaillées et des rapports personnalisés pour un suivi optimal.</p>
                        <a href="#" class="btn btn-link text-decoration-none">En savoir plus →</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="py-5 bg-primary text-white">
    <div class="container py-4 text-center">
        <h2 class="fw-bold mb-4">Prêt à transformer votre gestion scolaire ?</h2>
        <p class="lead mb-4">Rejoignez dès maintenant les établissements qui nous font confiance</p>
        <a href="#" class="btn btn-light btn-lg px-4 me-2">Commencer l'essai gratuit</a>
        <a href="#" class="btn btn-outline-light btn-lg px-4">Contactez-nous</a>
    </div>
</section>

<!-- Footer -->
<footer class="bg-dark text-white py-4">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <p class="mb-0">&copy; {{ date('Y') }} Gestion Scolaire. Tous droits réservés.</p>
            </div>
            <div class="col-md-6 text-md-end">
                <a href="#" class="text-white text-decoration-none me-3">Mentions légales</a>
                <a href="#" class="text-white text-decoration-none me-3">Confidentialité</a>
                <a href="#" class="text-white text-decoration-none">Contact</a>
            </div>
        </div>
    </div>
</footer>
@endsection
