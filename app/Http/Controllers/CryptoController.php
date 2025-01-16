<?php

namespace App\Http\Controllers;

use App\Exception\SoldeException;
use App\Models\Crypto;
use App\Services\TransCryptoService;
use Illuminate\Http\Request;

final class CryptoController extends Controller
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
            return $this->getView('achat.formAchat',$request,$data);
        }
        $data["message"]="Achat effectue avec succes";
        return $this->getView('achat.formAchat',$request,$data);
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
            return $this->getView('vente.formVente',$request,$data);
        }
        $data["message"]="Vente reussie";
        return $this->getView('vente.formVente',$request,$data);
    }

    public function findListeAchat(Request $request){
        $data["achats"]=$this->transCryptoService->findListeAchat($request->session()->get('idUtilisateur'));
        return $this->getView('achat.listeAchat',$request,$data);
    }

    public function findListeAchatAll(Request $request){
        $data["achats"]=$this->transCryptoService->findListeAchatAll();
        return $this->getView('achat.listeAchat',$request,$data);
    }

    public function findListVente(Request $request){
        $data["ventes"]=$this->transCryptoService->findListVente($request->session()->get('idUtilisateur'));
        return $this->getView('vente.listeVente',$request,$data);
    }

    public function findListeVenteAll(Request $request){
        $data["ventes"]=$this->transCryptoService->findListVenteAll();
        return $this->getView('vente.listeVente',$request,$data);
    }

    public function statistique(Request $request){
        $request->validate([
            "date"=>"date"
        ]);
        $date=$request->input('date');
        if($request->input('date') == null){
            $date = new \DateTime();
        }
        $data["statistiques"]=$this->transCryptoService->findStatistiqueTransaction($date);
        return $this->getView('dashboard.portefeuille',$request,$data);
    }

    public function fintPorfeuilleUtilisateur(Request $request){
        $data["portefeuilles"]=$this->transCryptoService->findPorfeuilleUtilisateur($request->session()->get('idUtilisateur'));
        return $this->getView('portefeuille.listePortefeuille',$request,$data);
    }

    public function formAchat(Request $request){
        $data["cryptos"] = Crypto::all();
        $data["message"] = "Insertion d'achat";
        return $this->getView('achat.formAchat',$request,$data);
    }

    public function formVente(Request $request){
        $data["cryptos"] = Crypto::all();
        $data["message"] = "Insertion de vente";
        return $this->getView('vente.formVente',$request,$data);
    }
}
