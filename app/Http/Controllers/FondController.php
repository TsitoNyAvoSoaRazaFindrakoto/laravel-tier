<?php

namespace App\Http\Controllers;

use App\Models\FondUtilisateur;
use Illuminate\Http\Request;

class FondController extends Controller
{
    public function formDepot(){
        return view('fond.formDepot');
    }
    public function insertDepot(Request $request){
        $request->validate([
            "montant"=>"required|numeric|min:1",
        ]);
        FondUtilisateur::create([
            "entree"=>$request->input("montant"),
            "sortie"=>0,
            "idUtilisateur"=>$request->session()->get("idUtilisateur")
        ]);
    }

    public function formRetrait(){
        return view('fond.formRetrait');
    }

    public function insertRetrait(Request $request){
        $request->validate([
            "montant"=>"required|numeric|min:1",
        ]);
        FondUtilisateur::create([
            "entree"=>0,
            "sortie"=>$request->input("montant"),
            "idUtilisateur"=>$request->session()->get("idUtilisateur")
        ]);
    }
}
