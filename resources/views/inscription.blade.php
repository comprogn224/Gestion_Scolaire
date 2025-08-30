@extends('layouts.app')

@section('title', 'Inscription - Gestion Scolaire')

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
@endpush

@section('content')
<div class="bg-light">

  <div class="container d-flex justify-content-center align-items-center min-vh-100 py-5">
    <div class="card shadow p-4 w-100" style="max-width: 450px;">
      
      <!-- Logo -->
      <div class="text-center mb-3">
        <div class="bg-success rounded-circle d-flex align-items-center justify-content-center mx-auto" style="width: 60px; height: 60px;">
          <i class="bi bi-person-plus-fill text-white fs-3"></i>
        </div>
      </div>

      <!-- Titre -->
      <h4 class="text-center mb-2">Créer un compte</h4>
      <p class="text-center text-muted">Inscrivez-vous pour accéder à votre espace scolaire</p>

      <!-- Formulaire -->
      <form>
        <div class="mb-3">
          <label for="name" class="form-label">Nom complet</label>
          <input type="text" id="name" class="form-control" placeholder="Votre nom complet" required>
        </div>

        <div class="mb-3">
          <label for="email" class="form-label">Email</label>
          <input type="email" id="email" class="form-control" placeholder="exemple@email.com" required>
        </div>

        <div class="mb-3">
          <label for="role" class="form-label">Rôle</label>
          <select id="role" class="form-select" required>
            <option value="">-- Sélectionnez votre rôle --</option>
            <option value="admin">Admin</option>
            <option value="professeur">Professeur</option>
            <option value="eleve">Élève</option>
          </select>
        </div>

        <div class="mb-3">
          <label for="password" class="form-label">Mot de passe</label>
          <input type="password" id="password" class="form-control" placeholder="********" required>
        </div>

        <div class="mb-3">
          <label for="password_confirmation" class="form-label">Confirmer le mot de passe</label>
          <input type="password" id="password_confirmation" class="form-control" placeholder="********" required>
        </div>

        <div class="d-grid">
          <button type="submit" class="btn btn-success">S'inscrire</button>
        </div>
      </form>

      <!-- Lien vers connexion -->
      <div class="text-center mt-3">
        <p class="small text-muted">Déjà un compte ? 
          <a href="{{ route('login') }}" class="text-success fw-bold">Se connecter</a>
        </p>
      </div>
    </div>
  </div>

@endsection
