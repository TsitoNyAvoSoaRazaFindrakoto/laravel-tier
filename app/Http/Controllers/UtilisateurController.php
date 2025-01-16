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
        $request->session()->put('token',$data['token']);
        return view('utilisateur.pin',$data);
    }

    public function inscription(){
        return view('utilisateur.inscription');
    }

    public function setSession(Request $request){
        if($request->session()->get('token')!=$request->input('token')){
            return redirect()->route('utilisateur.login');
        }
        $request->session()->put('idUtilisateur',$request->input('idUtilisateur'));
        $request->session()->put('role',$request->input('role'));
        $request->session()->put('connected',true);
        return redirect()->route('achat.liste');
    }

    public function logout(Request $request){
        $request->session()->invalidate();
        return redirect("/");
    }

    public function loginFafana(Request $request){
        $request->session()->put('idUtilisateur',1);
        $request->session()->put('role',"Membre simple");
        $request->session()->put('connected',true);
        return redirect()->route('achat.liste');
    }
}
