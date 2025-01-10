<?php

namespace App\Http\Controllers;

use App\Exception\SoldeException;
use App\Models\Crypto;
use App\Services\TransCryptoService;
use Illuminate\Http\Request;
use Illuminate\View\View;

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

    
    public function insertVente(Request $request){
        $request->validate([
            "quantite"=>"required|numeric|min:1",
            "montant"=>"required|numeric|min:0",
            "idCrypto"=>"required|numeric",
        ]);
        $data["cryptos"] = Crypto::all();
        try{
            $this->transCryptoService->insertVente($request);
        }
        catch(\Exception $e){
            $data["message"]=$e->getMessage();
            return view('vente.formVente',$data);
        }
        $data["message"]="Vente reussie";
        return view('vente.formVente',$data);
    }

    public function findListeAchat(Request $request){
        $data["achats"]=$this->transCryptoService->findListeAchat($request->session()->get('idUtilisateur'));
        return view('achat.listeAchat',$data);
    }
    
    public function findListVente(Request $request){
        $data["ventes"]=$this->transCryptoService->findListVente($request->session()->get('idUtilisateur'));
        return view('vente.listeVente',$data);
    }

    public function formAchat(){
        $data["cryptos"] = Crypto::all();
        $data["message"] = "Insertion d'achat";
        return view('achat.formAchat',$data);
    }

    public function formVente(){
        $data["cryptos"] = Crypto::all();
        $data["message"] = "Insertion de vente";
        return view('vente.formVente',$data);
    }
}
