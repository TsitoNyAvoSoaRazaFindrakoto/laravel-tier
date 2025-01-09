<?php

namespace App\Http\Controllers;

use App\Models\Crypto;
use App\Services\CryptoService;
use App\Services\TransCryptoService;
use Illuminate\Http\Request;
use Illuminate\View\View;

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
        $this->transCryptoService->insertAchat($request);
    }

    public function insertVente(Request $request){
        $request->validate([
            "quantite"=>"required|numeric|min:1",
            "montant"=>"required|numeric|min:0",
            "idCrypto"=>"required|numeric",
        ]);
        try{
            $this->transCryptoService->insertVente($request);
        }
        catch(\Exception $e){
            $data["message"]=$e->getMessage();
            return view('cryptos.formVente',$data);
        }
        $data["message"]="Vente reussie";
        return view('cryptos.formVente',$data);
    }

    public function findListVente(Request $request){
        $data["ventes"]=$this->transCryptoService->findVente($request->session()->get('idUtilisateur'));
        return view('cryptos.listVente',$data);
    }

    public function formAchat(){
        $data["cryptos"] = Crypto::all();
        return view('cryptos.formAchat',$data);
    }

    public function formVente(){
        $data["cryptos"] = Crypto::all();
        return view('cryptos.formVente',$data);
    }
}
