<?php

namespace App\Http\Controllers;

use App\Exception\SoldeException;
use App\Models\Crypto;
use App\Services\TransCryptoService;
use Illuminate\Http\Request;

class CryptoController extends Controller
{
    protected TransCryptoService $transCryptoService;
    public function __construct(TransCryptoService $transCryptoService){
        $this->transCryptoService = $transCryptoService;
    }
    public function insertAchat(Request $request){
        $request->validate([
            "quantite"=>"required|numeric|min:1",
            "montant"=>"required|numeric|min:0",
            "idCrypto"=>"required|numeric",
        ]);
        $data["cryptos"] = Crypto::all();
        try{
            $this->transCryptoService->insertAchat($request);
        }
        catch(SoldeException $e){
            $data["message"]=$e->getMessage();
            return view('achat.formAchat',$data);
        }
        $data["message"]="Achat effectue avec succes";
        return view('achat.formAchat',$data);
    }

    public function findListeAchat(Request $request){
        $data["achats"]=$this->transCryptoService->findListeAchat($request->session()->get('idUtilisateur'));
        return view('achat.listeAchat',$data);
    }

    public function formAchat(){
        $data["cryptos"] = Crypto::all();
        $data["message"] = "Insertion d'achat";
        return view('achat.formAchat',$data);
    }
}
