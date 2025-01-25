<?php

namespace App\Http\Controllers;

use App\Models\FondUtilisateur;
use App\Models\FondUtilisateurRequest;
use App\Services\FondService;
use Illuminate\Http\Request;

class FondController extends Controller
{
    protected FondService $fondService;
    public function __construct(FondService $fondService)
    {
        $this->fondService = $fondService;
    }

    public function formDepot(Request $request){
        return $this->getView('fond.formDepot',$request);
    }

    public function findTransactionRequest(Request $request){
        $data["transactionsFond"]=FondUtilisateurRequest::all();
        return $this->getView('utilisateur.transactionRequest',$request,$data);
    }

    public function acceptTransaction(string $idTransaction,Request $request){
        $this->fondService->acceptTransaction($idTransaction);
        return redirect()->back();
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
