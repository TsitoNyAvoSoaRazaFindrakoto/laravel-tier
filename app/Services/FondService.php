<?php

namespace App\Services;
use App\Models\FondUtilisateur;
use Illuminate\Http\Request;

class FondService
{
    public function insertRetrait(Request $request){
        $idUtilisateur=$request->session()->get('idUtilisateur');
        $montant=$request->input('montant');
        if($this->findSolde($idUtilisateur)<$montant){
            throw new \Error("Solde n'est pas valide");
        }
        $fondUtilisateur = new FondUtilisateur();
        $fondUtilisateur->sortie=$montant;
        $fondUtilisateur->entree=0;
        $fondUtilisateur->idUtilisateur=$request->session()->get('idUtilisateur');
        $fondUtilisateur->save();
    }

    public function insertDepot(Request $request){
        $fondUtilisateur = new FondUtilisateur();
        $fondUtilisateur->sortie=0;
        $fondUtilisateur->entree=$request->input('montant');
        $fondUtilisateur->idUtilisateur=$request->session()->get('idUtilisateur');
        $fondUtilisateur->save();
    }

    public function findSolde($idUtilisateur){
        return FondUtilisateur::where('idUtilisateur',$idUtilisateur)
            ->selectRaw('sum(entree-sortie) as solde')
            ->first()['solde'];
    }
}
