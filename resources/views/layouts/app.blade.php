<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield("title", "Gestion Scolaire")</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    @stack('styles')
    <style>
    :root {
        --bs-font-sans-serif: 'Inter', system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        --bs-body-line-height: 1.6;
        --bs-body-font-size: 1rem;
        --bs-body-font-weight: 400;
        --bs-heading-line-height: 1.2;
        --bs-primary: #0d6efd;
        --bs-primary-rgb: 13, 110, 253;
        --bs-link-color: #0d6efd;
        --bs-link-hover-color: #0a58ca;
        --bs-primary-bg-subtle: #cfe2ff;
        --bs-primary-border-subtle: #9ec5fe;
        --bs-primary-text: #084298;
    }
    
    body {
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
        text-rendering: optimizeLegibility;
        font-kerning: normal;
    }
    
    h1, .h1, h2, .h2, h3, .h3, h4, .h4, h5, .h5, h6, .h6 {
        font-weight: 700;
        line-height: var(--bs-heading-line-height);
        margin-bottom: 0.75rem;
    }
    
    h1, .h1 { font-size: calc(1.375rem + 1.5vw); }
    h2, .h2 { font-size: calc(1.325rem + 0.9vw); }
    h3, .h3 { font-size: calc(1.3rem + 0.6vw); }
    h4, .h4 { font-size: 1.5rem; }
    h5, .h5 { font-size: 1.25rem; }
    h6, .h6 { font-size: 1rem; }
    
    p {
        margin-bottom: 1.25rem;
        font-size: 1rem;
        line-height: 1.75;
    }
    
    .lead {
        font-size: 1.25rem;
        font-weight: 400;
        line-height: 1.6;
    }
    
    .container, .container-fluid {
        padding-left: 1.5rem;
        padding-right: 1.5rem;
    }
    
    @media (min-width: 1200px) {
        .container, .container-lg, .container-md, .container-sm, .container-xl {
            max-width: 1140px;
        }
    }
    
    @media (max-width: 767.98px) {
        :root {
            --bs-body-font-size: 0.9375rem;
        }
        
        h1, .h1 { font-size: calc(1.25rem + 1.5vw); }
        h2, .h2 { font-size: calc(1.2rem + 0.9vw); }
        h3, .h3 { font-size: calc(1.175rem + 0.6vw); }
        
        .container, .container-fluid {
            padding-left: 1rem;
            padding-right: 1rem;
        }
    }
        .navbar {
            box-shadow: 0 2px 4px rgba(0,0,0,.1);
            background: linear-gradient(135deg, #0d6efd 0%, #0dcaf0 100%) !important;
        }
        .navbar-brand {
            font-weight: 700;
            letter-spacing: 0.5px;
        }
        .nav-link {
            position: relative;
            font-weight: 500;
            padding: 0.5rem 1rem !important;
            margin: 0 0.25rem;
        }
        .nav-link:after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: 0;
            left: 50%;
            background-color: #20c997;
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }
        .nav-link:hover:after {
            width: 70%;
        }
        .dropdown-menu {
            border: none;
            box-shadow: 0 4px 12px rgba(0,0,0,.1);
            border-radius: 0.5rem;
            margin-top: 0.5rem;
        }
        .dropdown-item {
            padding: 0.5rem 1.5rem;
            font-weight: 400;
        }
        .dropdown-item:hover {
            background-color: #f8f9fa;
            color: #20c997;
        }
    </style>
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
                    <i class="fas fa-graduation-cap me-2"></i>
                    Gestion Scolaire
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" 
                        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link active" href="{{ url('/') }}">Accueil</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="elevesDropdown" role="button" 
                               data-bs-toggle="dropdown" aria-expanded="false">
                                Élèves
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="elevesDropdown">
                                <li><a class="dropdown-item" href="#">Liste des élèves</a></li>
                                <li><a class="dropdown-item" href="#">Ajouter un élève</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="#">Statistiques</a></li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Classes</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Notes</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Emploi du temps</a>
                        </li>
                        <li class="nav-item ms-lg-3">
                            <a href="{{ route('login') }}" class="btn btn-outline-light">
                                <i class="fas fa-sign-in-alt me-1"></i> Connexion
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main class="main-content">
        <div class="container-fluid px-0">
            @yield('content')
        </div>
    </main>
    
    <style>
    .main-content {
        min-height: calc(100vh - 400px); /* Hauteur minimale pour pousser le footer */
        padding: 2rem 0;
    }
    
    @media (max-width: 767.98px) {
        .main-content {
            padding: 1.5rem 0;
        }
    }

    <footer class="bg-dark text-white pt-5 pb-4">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4 mb-0 mb-lg-0">
                    <div class="d-flex align-items-center mb-3">
                        <i class="fas fa-graduation-cap fa-2x text-primary me-2"></i>
                        <h4 class="mb-0 fw-bold">Gestion Scolaire</h4>
                    </div>
                    <p class="text-white-50 mb-4">Une solution complète pour la gestion efficace de votre établissement scolaire. Simplifiez votre quotidien avec nos outils puissants et intuitifs.</p>
                    <div class="d-flex gap-3">
                        <a href="#" class="text-white-50 hover-text-primary fs-5"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="text-white-50 hover-text-primary fs-5"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-white-50 hover-text-primary fs-5"><i class="fab fa-linkedin-in"></i></a>
                        <a href="#" class="text-white-50 hover-text-primary fs-5"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
                
                <div class="col-6 col-md-3 col-lg-2">
                    <h5 class="text-uppercase fw-bold mb-4">Navigation</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="{{ url('/') }}" class="text-white-50 text-decoration-none hover-text-primary">Accueil</a></li>
                        <li class="mb-2"><a href="#features" class="text-white-50 text-decoration-none hover-text-primary">Fonctionnalités</a></li>
                        <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none hover-text-primary">Tarifs</a></li>
                        <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none hover-text-primary">Blog</a></li>
                        <li><a href="#" class="text-white-50 text-decoration-none hover-text-primary">Contact</a></li>
                    </ul>
                </div>
                
                <div class="col-6 col-md-3 col-lg-2">
                    <h5 class="text-uppercase fw-bold mb-4">Légal</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none hover-text-primary">Mentions légales</a></li>
                        <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none hover-text-primary">Politique de confidentialité</a></li>
                        <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none hover-text-primary">CGU</a></li>
                        <li><a href="#" class="text-white-50 text-decoration-none hover-text-primary">CGV</a></li>
                    </ul>
                </div>
                
                <div class="col-md-6 col-lg-4">
                    <h5 class="text-uppercase fw-bold mb-4">Newsletter</h5>
                    <p class="text-white-50 mb-3">Inscrivez-vous pour recevoir nos dernières actualités et offres.</p>
                    <form class="mb-3">
                        <div class="input-group">
                            <input type="email" class="form-control bg-dark text-white border-secondary" placeholder="Votre email" aria-label="Votre email">
                            <button class="btn btn-primary" type="submit">
                                <i class="fas fa-paper-plane"></i>
                            </button>
                        </div>
                    </form>
                    <p class="small text-white-50 mb-0">En vous inscrivant, vous acceptez notre politique de confidentialité.</p>
                </div>
            </div>
            
            <hr class="my-4 border-secondary">
            
            <div class="row align-items-center">
                <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                    <p class="mb-0 text-white-50">&copy; {{ date('Y') }} Gestion Scolaire. Tous droits réservés.</p>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <img src="https://cdn.jsdelivr.net/gh/atomiclabs/cryptocurrency-icons@d5c68edec1f5eaec59ac77ff2b48144679efbae1/svg/color/generic.svg" alt="Paiement sécurisé" height="24" class="me-2">
                    <img src="https://cdn.jsdelivr.net/gh/atomiclabs/cryptocurrency-icons@d5c68edec1f5eaec59ac77ff2b48144679efbae1/svg/color/visa.svg" alt="Visa" height="24" class="me-2">
                    <img src="https://cdn.jsdelivr.net/gh/atomiclabs/cryptocurrency-icons@d5c68edec1f5eaec59ac77ff2b48144679efbae1/svg/color/mastercard.svg" alt="Mastercard" height="24">
                </div>
            </div>
        </div>
    </footer>
    
    <style>
    /* Transitions et effets de survol */
    .hover-text-primary {
        transition: color 0.2s ease, background-color 0.2s ease, border-color 0.2s ease, box-shadow 0.2s ease;
    }
    
    .hover-text-primary:hover {
        color: #0d6efd !important;
    }
    
    /* Espacements cohérents */
    .section {
        padding: 5rem 0;
    }
    
    .section-sm {
        padding: 3rem 0;
    }
    
    .section-lg {
        padding: 7rem 0;
    }
    
    /* Boutons améliorés */
    .btn {
        font-weight: 500;
        padding: 0.5rem 1.25rem;
        transition: all 0.2s ease;
        border-radius: 0.375rem;
    }
    
    .btn-lg {
        padding: 0.75rem 1.5rem;
        font-size: 1.1rem;
    }
    
    /* Cartes */
    .card {
        border: none;
        border-radius: 0.5rem;
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.05);
    }
    
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 1rem 2rem rgba(0, 0, 0, 0.1);
    }
    
    /* Images responsives */
    .img-fluid {
        max-width: 100%;
        height: auto;
    }
    
    /* Utilitaires d'espacement */
    .gap-1 { gap: 0.5rem; }
    .gap-2 { gap: 1rem; }
    .gap-3 { gap: 1.5rem; }
    .gap-4 { gap: 2rem; }
    
    /* Améliorations pour les petits écrans */
    @media (max-width: 767.98px) {
        .section {
            padding: 3rem 0;
        }
        
        .section-sm {
            padding: 2rem 0;
        }
        
        .section-lg {
            padding: 5rem 0;
        }
        
        .btn, .btn-lg {
            width: 100%;
            margin-bottom: 0.5rem;
        }
    }
    
    /* Amélioration de la lisibilité */
    a {
        text-decoration: none;
        transition: color 0.2s ease;
    }
    
    /* Optimisation du contraste pour l'accessibilité */
    .text-muted {
        color: #6c757d !important;
    }
    
    /* Mise en avant bleu ciel */
    .highlight-blue {
        color: #0dcaf0;
        font-weight: 600;
    }
    
    .bg-highlight-blue {
        background-color: #e7f5ff;
        border-left: 4px solid #0dcaf0;
        padding: 1rem;
        border-radius: 0 0.5rem 0.5rem 0;
    }
    
    .btn-highlight-blue {
        background-color: #0dcaf0;
        border-color: #0dcaf0;
        color: #fff;
    }
    
    .btn-highlight-blue:hover {
        background-color: #0ba4c4;
        border-color: #0ba4c4;
        color: #fff;
    }
    
    /* Amélioration des formulaires */
    .form-control, .form-select {
        padding: 0.5rem 0.75rem;
        border-radius: 0.375rem;
        border: 1px solid #dee2e6;
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: #86b7fe;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15);
    }
    </style>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    @stack('scripts')
</body>
</html>
