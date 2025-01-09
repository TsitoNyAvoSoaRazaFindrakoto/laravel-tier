<?php

namespace App\Services;
use App\Exception\SoldeException;
use App\Models\FondUtilisateur;
use Illuminate\Http\Request;

final class FondService
{
    public function insertRetrait(Request $request){
        $idUtilisateur=$request->session()->get('idUtilisateur');
        $montant=$request->input('montant')*$request->input('quantite');
        $solde=$this->findSolde($idUtilisateur);
        if($solde<$montant){
            throw new SoldeException($montant,$solde);
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
