<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UtilisateurController extends Controller
{
    
    public function verifierConnection(Request $resquest){
        $request->validate([
            "email"=>"required|text",
            "password"=>"required|text",
        ]);

        
    }
}
