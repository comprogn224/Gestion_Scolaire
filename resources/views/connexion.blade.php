@extends('layouts.app')

@section('title', 'Connexion - Gestion Scolaire')

@section('content')
<div class="bg-light">

  <div class="container d-flex justify-content-center align-items-center min-vh-100 py-5">
    <div class="card shadow p-4" style="max-width: 400px; width: 100%;">
      
      <!-- Logo -->
      <div class="text-center mb-3">
        <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center mx-auto" style="width: 60px; height: 60px;">
          <i class="bi bi-mortarboard-fill text-white fs-3"></i>
        </div>
      </div>

      <!-- Titre -->
      <h4 class="text-center mb-2">EduManager</h4>
      <p class="text-center text-muted">Connectez-vous à votre espace de gestion scolaire</p>

      <!-- Formulaire -->
      <form>
        <div class="mb-3">
          <label for="email" class="form-label">Email</label>
          <input type="email" id="email" class="form-control" placeholder="votre@email.com">
        </div>

        <div class="mb-3">
          <label for="password" class="form-label">Mot de passe</label>
          <input type="password" id="password" class="form-control" placeholder="********">
        </div>

        <div class="d-grid">
          <button type="submit" class="btn btn-primary">Se connecter</button>
        </div>

        <div class="text-center mt-3">
          <p class="small text-muted">Pas encore de compte ? 
            <a href="{{ route('register') }}" class="text-primary fw-bold">S'inscrire</a>
          </p>
        </div>
      </form>

      <!-- Comptes de démo -->
      <div class="mt-4">
        <p class="fw-bold mb-1">Comptes de démonstration :</p>
        <ul class="small text-muted">
          <li>Admin: admin@school.com</li>
          <li>Professeur: prof@school.com</li>
          <li>Élève: eleve@school.com</li>
        </ul>
        <p class="small text-muted">Mot de passe: <code>password</code></p>
      </div>
    </div>
  </div>

@endsection

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
@endpush
