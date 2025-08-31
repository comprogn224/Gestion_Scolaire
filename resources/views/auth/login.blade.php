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
      <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="mb-3">
          <label for="email" class="form-label">Email</label>
          <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="votre@email.com">
          @error('email')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
          @enderror
        </div>

        <div class="mb-3">
          <label for="password" class="form-label">Mot de passe</label>
          <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" required autocomplete="current-password" placeholder="********">
          @error('password')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
          @enderror
        </div>

        <div class="mb-3 form-check">
          <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
          <label class="form-check-label" for="remember">
            {{ __('Se souvenir de moi') }}
          </label>
        </div>

        <div class="d-grid mb-3">
          <button type="submit" class="btn btn-primary">
            {{ __('Se connecter') }}
          </button>
        </div>

        @if (Route::has('password.request'))
          <div class="text-center">
            <a class="btn btn-link" href="{{ route('password.request') }}">
              {{ __('Mot de passe oublié ?') }}
            </a>
          </div>
        @endif

        <div class="text-center mt-3">
          <p class="small text-muted">Pas encore de compte ? 
            <a href="{{ route('register') }}" class="text-primary fw-bold">S'inscrire</a>
          </p>
        </div>
      </form>

      @if (session('status'))
        <div class="alert alert-success" role="alert">
          {{ session('status') }}
        </div>
      @endif

      @if (session('error'))
        <div class="alert alert-danger" role="alert">
          {{ session('error') }}
        </div>
      @endif

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
