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
      <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="mb-3">
          <label for="name" class="form-label">Nom complet</label>
          <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="Votre nom complet">
          @error('name')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
          @enderror
        </div>

        <div class="mb-3">
          <label for="email" class="form-label">Email</label>
          <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="exemple@email.com">
          @error('email')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
          @enderror
        </div>

        <div class="mb-3">
          <label for="role" class="form-label">Rôle</label>
          <select id="role" class="form-select @error('role') is-invalid @enderror" name="role" required>
            <option value="">-- Sélectionnez votre rôle --</option>
            <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
            <option value="professeur" {{ old('role') == 'professeur' ? 'selected' : '' }}>Professeur</option>
            <option value="eleve" {{ old('role') == 'eleve' ? 'selected' : '' }}>Élève</option>
          </select>
          @error('role')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
          @enderror
        </div>

        <div class="mb-3">
          <label for="password" class="form-label">Mot de passe</label>
          <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="********">
          @error('password')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
          @enderror
        </div>

        <div class="mb-3">
          <label for="password_confirmation" class="form-label">Confirmer le mot de passe</label>
          <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="********">
        </div>

        <div class="d-grid">
          <button type="submit" class="btn btn-success">S'inscrire</button>
        </div>
      </form>

      @if (session('status'))
        <div class="alert alert-success" role="alert">
          {{ session('status') }}
        </div>
      @endif

      @if (session('error'))
        <div class="alert alert-danger" role="alert">
          {{ session('error') }
        </div>
      @endif

      <!-- Lien vers connexion -->
      <div class="text-center mt-3">
        <p class="small text-muted">Déjà un compte ? 
          <a href="{{ route('login') }}" class="text-success fw-bold">Se connecter</a>
        </p>
      </div>
    </div>
  </div>

@endsection
