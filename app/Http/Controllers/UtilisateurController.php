<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UtilisateurController extends Controller
{

    public function login(){
        return view('utilisateur.login');
    }
}
