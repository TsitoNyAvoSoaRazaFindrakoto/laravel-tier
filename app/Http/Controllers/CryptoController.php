<?php

namespace App\Http\Controllers;

use App\Dto\ResponseJSON;
use App\Exception\SoldeCryptoException;
use App\Exception\SoldeException;
use App\Models\Crypto;
use App\Models\Utilisateur;
use App\Services\TransCryptoService;
use Illuminate\Http\Request;

final class CryptoController extends Controller
{
    protected TransCryptoService $transCryptoService;
    public function __construct(TransCryptoService $transCryptoService){
        $this->transCryptoService = $transCryptoService;
    }
    public function insertAchat(Request $request): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
    {
        $request->validate([
            "quantite"=>"required|numeric|min:1",
            "idCrypto"=>"required|numeric",
        ]);
        try{
            $response=$this->transCryptoService->insertAchat($request);
            return view('achat.validationAchat',$response);
        }
        catch(SoldeException $e){
            $data["message"]=$e->getMessage();
            return $this->getView('achat.formAchat',$request,$data);
        }
    }
    public function insertAchatValidated(Request $request): ResponseJSON
    {
        $data=$this->transCryptoService->insertAchatValidated($request);
        return new ResponseJSON(200,"Insertion effectue",$data);
    }

    public function insertVente(Request $request): ResponseJSON
    {
        $request->validate([
            "quantite"=>"required|numeric|min:1",
            "idCrypto"=>"required|numeric",
        ]);
        $data["cryptos"] = Crypto::all();
        try{
            $data=$this->transCryptoService->insertVente($request);
        }
        catch(SoldeCryptoException $e){
            return new ResponseJSON(422,$e->getMessage());
        }
        return new ResponseJSON(200,"Vente réussie",$data);
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
        $data["achats"]=$this->transCryptoService->findListeAchatAll();
        $data["ventes"]=$this->transCryptoService->findListVente($request->session()->get('idUtilisateur'));
        return $this->getView('vente.listeVente',$request,$data);
    }

    public function findAllTransaction(Request $request){
        $request->validate([
            "page"=>"numeric",
        ]);
        $data["page"]=$request->input('page');
        if($data["page"]==null){
            $data["page"]=1;
        }
        $data["transactions"]=$this->transCryptoService->findAllTransaction();
        $data["nbPages"]=$data["transactions"]->lastPage();
        $data["path"]=$data["transactions"]->path();
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
