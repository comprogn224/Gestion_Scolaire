<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Afficher le tableau de bord en fonction du rôle de l'utilisateur
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $user = Auth::user();
        
        if ($user->role === 'admin') {
            return view('dashboard.admin');
        } elseif ($user->role === 'professeur') {
            return view('dashboard.professeur');
        } elseif ($user->role === 'eleve') {
            return view('dashboard.eleve');
        }
        
        return view('dashboard.default');
    }
}
