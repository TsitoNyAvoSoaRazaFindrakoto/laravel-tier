<?php

namespace App\Http\Controllers;

use App\Models\FondUtilisateur;
use App\Models\FondUtilisateurRequest;
use App\Services\FondService;
use Illuminate\Http\Request;

final class FondController extends Controller
{
    protected FondService $fondService;
    public function __construct(FondService $fondService)
    {
        $this->fondService = $fondService;
    }

    public function formDepot(Request $request){
        return $this->getView('fond.formDepot',$request);
    }

    public function findListeDepot(Request $request){
        $data["depots"]=FondUtilisateurRequest::where('entree','>',0)->get();
        return $this->getView('fond.listeDepot',$request,$data);
    }

    public function findListeRetrait(Request $request){
        $data["depots"]=FondUtilisateurRequest::where('sortie','>',0)->get();
        return $this->getView('fond.listeDepot',$request,$data);
    }

    public function acceptTransaction(string $idTransaction,Request $request){
        $this->fondService->acceptTransaction($idTransaction);
        return $this->getView('fond.listeDepot',$request);
    }

    public function insertDepot(Request $request){
        $request->validate([
            "montant"=>"required|numeric|min:1",
        ]);
        $this->fondService->insertDepotWithoutCrypto($request);
        return redirect()->back();
    }

    public function formRetrait(Request $request){
        return $this->getView('fond.formRetrait',$request);
    }

    public function insertRetrait(Request $request){
        $request->validate([
            "montant"=>"required|numeric|min:1",
        ]);
        $this->fondService->insertRetraitWithoutCrypto($request);
        return redirect()->route('portefeuille.liste');
    }
}
