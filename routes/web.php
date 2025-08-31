<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\EleveController;
use App\Http\Controllers\ProfesseurController;
use App\Http\Controllers\MatiereController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\ClasseController;
use App\Http\Controllers\AbsenceController;
use App\Http\Controllers\ParametreController;
use App\Http\Controllers\DashboardController;

// Page d'accueil
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Routes d'authentification
Auth::routes(['verify' => true]);

// Routes protégées par authentification
Route::middleware(['auth'])->group(function () {
    // Tableau de bord principal
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Tableaux de bord spécifiques aux rôles
    Route::prefix('admin')->middleware(['role:admin'])->group(function () {
        Route::get('/dashboard', function () {
            return view('dashboard.admin');
        })->name('admin.dashboard');
    });

    Route::prefix('professeur')->middleware(['role:professeur'])->group(function () {
        Route::get('/dashboard', function () {
            return view('dashboard.professeur');
        })->name('professeur.dashboard');
    });

    Route::prefix('eleve')->middleware(['role:eleve'])->group(function () {
        Route::get('/dashboard', function () {
            return view('dashboard.eleve');
        })->name('eleve.dashboard');
    });
});

// Routes pour les élèves
Route::prefix('eleves')->name('eleves.')->group(function () {
    Route::get('/', [EleveController::class, 'index'])->name('index');
    Route::get('/create', [EleveController::class, 'create'])->name('create');
    Route::post('/', [EleveController::class, 'store'])->name('store');
    Route::get('/{eleve}', [EleveController::class, 'show'])->name('show');
    Route::get('/{eleve}/edit', [EleveController::class, 'edit'])->name('edit');
    Route::put('/{eleve}', [EleveController::class, 'update'])->name('update');
    Route::delete('/{eleve}', [EleveController::class, 'destroy'])->name('destroy');
    Route::get('/{eleve}/bulletin', [EleveController::class, 'bulletin'])->name('bulletin');
    Route::get('/{eleve}/absences', [EleveController::class, 'absences'])->name('absences');
});

// Routes pour les professeurs
Route::resource('professeurs', ProfesseurController::class)->except(['show']);

// Routes pour les classes
Route::resource('classes', ClasseController::class);

// Routes pour les matières
Route::resource('matieres', MatiereController::class);

// Routes pour les notes
Route::resource('notes', NoteController::class);

// Routes pour les absences
Route::resource('absences', AbsenceController::class);

// Routes pour les paramètres
Route::prefix('parametres')->name('parametres.')->group(function () {
    Route::get('/', [ParametreController::class, 'index'])->name('index');
    Route::put('/update', [ParametreController::class, 'update'])->name('update');
});

// Routes d'authentification
Auth::routes();

// Route du tableau de bord après connexion
Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
