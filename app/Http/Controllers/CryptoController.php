<?php

namespace App\Http\Controllers;

use App\Exception\SoldeException;
use App\Models\Crypto;
use App\Services\CryptoService;
use App\Services\TransCryptoService;
use Illuminate\Http\Request;

class CryptoController extends Controller
{
    protected TransCryptoService $transCryptoService;
    public function __construct(CryptoService $cryptoService){
        $this->cryptoService = $cryptoService;
    }
    public function insertAchat(Request $request){
        $request->validate([
            "quantite"=>"required|numeric|min:1",
            "montant"=>"required|numeric|min:0",
            "idCrypto"=>"required|numeric",
        ]);
        try{
            $this->transCryptoService->insertAchat($request);
        }
        catch(SoldeException $e){
            $data["message"]=$e->getMessage();
            return view('crypto.formVente',$data);
        }
        $data["message"]="Achat effectue avec succes";
        return view('crypto.formVente',$data);
    }

    public function findListeAchat(Request $request){
        $data["achats"]=$this->transCryptoService->findListeAchat($request->session()->get('idUtilisateur'));
        return view('crypto.listeAchat',$data);
    }

    public function formAchat(){
        $data["cryptos"] = Crypto::all();
        return view('crypto.formAchat',$data);
    }
}
