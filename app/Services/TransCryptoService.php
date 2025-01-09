<?php

namespace App\Services;

use App\Exception\SoldeCryptoException;
use App\Models\TransCrypto;
use DateTime;
use Illuminate\Http\Request;

final class TransCryptoService
{

    protected FondService $fondService;

    public function __construct(FondService $fondService){
        $this->fondService = $fondService;
    }

    public function insertEntree(Request $request){
        $today=new DateTime();
        $transCrypto = new TransCrypto();
        $transCrypto->idUtilisateur=$request->session()->get('idUtilisateur');
        $transCrypto->dateTransaction=$today->format('Y-m-d');
        $transCrypto->entree=$request->input('quantite');
        $transCrypto->sortie=0;
        $transCrypto->idCrypto=$request->input('idCrypto');
        $transCrypto->save();
    }

    public function insertSortie(Request $request){
        $quantite=$request->input('quantite');
        if($quantite>$this->findSoldeCrypto($quantite)){
            throw new SoldeCryptoException();
        }
        $today=new DateTime();
        $transCrypto = new TransCrypto();
        $transCrypto->idUtilisateur=$request->session()->get('idUtilisateur');
        $transCrypto->dateTransaction=$today->format('Y-m-d');
        $transCrypto->entree=0;
        $transCrypto->sortie=$request->input('quantite');
        $transCrypto->idCrypto=$request->input('idCrypto');
        $transCrypto->save();
    }

    public function insertAchat(Request $request){
        $this->fondService->insertRetrait($request);
        $this->insertEntree($request);
    }

    public function insertVente(Request $request){
        try{
            DB::beginTransaction();
            $this->fondService->insertDepot($request);
            $this->insertSortie($request);
            DB::commit();
        }
        catch (SoldeCryptoException $e){
            DB::rollBack();
            throw $e;
        }
    }

    public function findSoldeCrypto($idUtilisateur){
        return TransCrypto::where('idUtilisateur',$idUtilisateur)
            ->selectRaw('sum(entree-sortie) as solde')
            ->first()['solde'];
    }
}
