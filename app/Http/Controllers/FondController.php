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

    public function findTransactionRequest(Request $request){
        $fonds=FondUtilisateurRequest::with('utilisateur')->get();
        foreach ($fonds as $fond){
            $fond->setCalculatedValue();
        }
        $data["transactionsFond"]=$fonds;
        return $this->getView('utilisateur.transactionRequest',$request,$data);
    }

    public function acceptTransaction(string $idTransaction,Request $request){
        $this->fondService->acceptTransaction($idTransaction);
        return redirect()->back();
    }

    public function declineTransaction(string $idTransaction,Request $request){
        $this->fondService->declineTransaction($idTransaction);
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
