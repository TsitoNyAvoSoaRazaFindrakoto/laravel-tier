<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UtilisateurController extends Controller
{

    public function login(){
        return view('utilisateur.login');
    }

    public function loginPin(Request $request){
        $data['token']=$request->input('token');
        return view('utilisateur.pin',$data);
    }

    public function setSession(Request $request){
        $request->session()->put('idUtilisateur',$request->input('idUtilisateur'));
        return redirect()->route('achat.liste');
    }
}
