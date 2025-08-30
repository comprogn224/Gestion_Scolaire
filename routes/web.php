<?php

use Illuminate\Support\Facades\Route;

// Page d'accueil redirige vers la connexion
Route::get('/', function () {
    return redirect()->route('parametre');
});

// page d'accueil
Route::get('/home', function () {
    return view('welcome');
})->name('home');

// Page de connexion
Route::get('/connexion', function () {
    return view('connexion');
})->name('login');

// Page d'inscription
Route::get('/inscription', function () {
    return view('inscription');
})->name('register');

// La page admin
Route::get('/admin', function () {
    return view('admin');
})->name('admin');

// La page professeur
Route::get('/professeur', function () {
    return view('professeur');
})->name('professeur');

// La page eleve
Route::get('/eleve', function () {
    return view('eleve');
})->name('eleve');

// La page parent
Route::get('/parent', function () {
    return view('parent');
})->name('parent');

// La page classe
Route::get('/classe', function () {
    return view('classe');
})->name('classe');

// La page matiere
Route::get('/matiere', function () {
    return view('matiere');
})->name('matiere');

// La page note
Route::get('/note', function () {
    return view('note');
})->name('note');

// La page absence
Route::get('/absence', function () {
    return view('absence');
})->name('absence');

// La page parametre
Route::get('/parametre', function () {
    return view('parametre');
})->name('parametre');
