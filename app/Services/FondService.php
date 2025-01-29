<?php

namespace App\Services;
use App\Exception\SoldeException;
use App\Models\CryptoPrix;
use App\Models\FondUtilisateur;
use App\Models\FondUtilisateurRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

final class FondService
{
    public function insertRetrait(Request $request){
        $fondUtilisateur=$this->createRetrait($request);
        $fondUtilisateur->save();
    }

    public function createRetrait(Request $request):FondUtilisateur{
        $idUtilisateur=$request->session()->get('idUtilisateur');
        $prix=CryptoPrix::where('idCrypto',$request->input('idCrypto'))->orderBy('dateHeure','desc')->first()->prixUnitaire;
        $montant=$prix*$request->input('quantite');
        $solde=$this->findSolde($idUtilisateur);
        if($solde<$montant){
            throw new SoldeException($montant,$solde);
        }
        $fondUtilisateur = new FondUtilisateur();
        $fondUtilisateur->sortie=$montant;
        $fondUtilisateur->entree=0;
        $fondUtilisateur->dateTransaction=new \DateTime();
        $fondUtilisateur->idUtilisateur=$request->session()->get('idUtilisateur');
        return $fondUtilisateur;
    }

    public function insertDepot(Request $request){
        $fondUtilisateur = new FondUtilisateur();
        $idUtilisateur=$request->session()->get('idUtilisateur');
        $prix=CryptoPrix::where('idCrypto',$request->input('idCrypto'))->orderBy('dateHeure','desc')->first()->prixUnitaire;
        $montant=$prix*$request->input('quantite');
        $fondUtilisateur->sortie=0;
        $fondUtilisateur->entree=$montant;
        $fondUtilisateur->dateTransaction=new \DateTime();
        $fondUtilisateur->idUtilisateur=$idUtilisateur;
        $fondUtilisateur->save();
    }

    public function findTransactionHistorique($dateMin,$dateMax,$idUtilisateur):Collection{
        if($dateMin==null){
            $dateMin=new \DateTime("0001-01-01");
            $dateMin=$dateMin->format('Y-m-d');
        }
        if($dateMax==null){
            $dateMax=new \DateTime("9999-12-31");
            $dateMax=$dateMax->format('Y-m-d');
        }
        $query=FondUtilisateur::with('utilisateur')->where('dateTransaction','>=',$dateMin)->where('dateTransaction','<=',$dateMax);
        if($idUtilisateur!=0){
            $query->where('idUtilisateur',$idUtilisateur);
        }
        $responses=$query->get();
        foreach ($responses as $response){
            $response->setCalculatedValue();
        }
        return $responses;
    }

    public function acceptTransaction(int $idDepot){
        /** @var FondUtilisateurRequest $fondUtilisateurRequest */
        $fondUtilisateurRequest = FondUtilisateurRequest::findOrFail($idDepot);
        $fond = $fondUtilisateurRequest->accept();
        $fond->save();
        $fondUtilisateurRequest->delete();
    }

    public function declineTransaction(int $idDepot){
        /** @var FondUtilisateurRequest $fondUtilisateurRequest */
        $fondUtilisateurRequest = FondUtilisateurRequest::findOrFail($idDepot);
        $fondUtilisateurRequest->delete();
    }

    public function insertDepotWithoutCrypto(Request $request){
        $fondUtilisateur = new FondUtilisateurRequest();
        $montant=$request->input('montant');
        $fondUtilisateur->sortie=0;
        $fondUtilisateur->entree=$montant;
        $fondUtilisateur->dateTransaction=new \DateTime();
        $fondUtilisateur->idUtilisateur=$request->session()->get('idUtilisateur');
        $fondUtilisateur->save();
    }

    public function insertRetraitWithoutCrypto(Request $request){
        $fondUtilisateur = new FondUtilisateurRequest();
        $idUtilisateur=$request->session()->get('idUtilisateur');
        $solde=$this->findSolde($idUtilisateur);
        $montant=$request->input('montant');
        if($solde<$montant){
            throw new SoldeException($montant,$solde);
        }
        $fondUtilisateur->dateTransaction=new \DateTime();
        $fondUtilisateur->sortie=$montant;
        $fondUtilisateur->entree=0;
        $fondUtilisateur->idUtilisateur=$idUtilisateur;
        $fondUtilisateur->save();
    }

    public function findSoldeFilter($idUtilisateur,\DateTimeInterface $dateMax){
        return FondUtilisateur::selectRaw('sum(entree-sortie) as solde')
            ->whereDate('dateTransaction','<=',$dateMax)
            ->where('idUtilisateur',$idUtilisateur)
            ->first()->solde;
    }

    public function findSolde($idUtilisateur){
        return FondUtilisateur::where('idUtilisateur',$idUtilisateur)
            ->selectRaw('sum(entree-sortie) as solde')
            ->first()['solde'];
    }
}
