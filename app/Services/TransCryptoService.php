<?php

namespace App\Services;

use App\Exception\SoldeCryptoException;
use App\Exception\SoldeException;
use App\Models\CryptoPrix;
use App\Models\TransCrypto;
use DateTime;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

final class TransCryptoService
{

    protected FondService $fondService;

    public function __construct(FondService $fondService){
        $this->fondService = $fondService;
    }

    public function insertEntree(Request $request){
        $transCrypto = $this->createEntree($request);
        $transCrypto->save();
    }

    public function createEntree(Request $request){
        $today=new DateTime();
        $transCrypto = new TransCrypto();
        $transCrypto->idUtilisateur=$request->session()->get('idUtilisateur');
        $transCrypto->dateTransaction=$today->format('Y-m-d');
        $transCrypto->entree=$request->input('quantite');
        $transCrypto->prixUnitaire=CryptoPrix::where('idCrypto',$request->input('idCrypto'))->orderBy('dateHeure','desc')->first()->prixUnitaire;
        $transCrypto->sortie=0;
        $transCrypto->idCrypto=$request->input('idCrypto');
        return $transCrypto;
    }

    public function insertSortie(Request $request){
        $quantite=$request->input('quantite');
        $solde=$this->findSoldeCrypto($request->session()->get('idUtilisateur'),$request->input('idCrypto'));
        if($quantite>$solde){
            throw new SoldeCryptoException($quantite,$solde);
        }
        $today=new DateTime();
        $transCrypto = new TransCrypto();
        $transCrypto->idUtilisateur=$request->session()->get('idUtilisateur');
        $transCrypto->dateTransaction=$today->format('Y-m-d');
        $transCrypto->entree=0;
        $transCrypto->prixUnitaire=CryptoPrix::where('idCrypto',$request->input('idCrypto'))->orderBy('dateHeure','desc')->first()->prixUnitaire;
        $transCrypto->sortie=$request->input('quantite');
        $transCrypto->idCrypto=$request->input('idCrypto');
        $transCrypto->save();
    }

    public function insertAchatValidated(Request $request)
    {
        try{
            DB::beginTransaction();
            $request->session()->get('retrait')->save();
            $request->session()->get('entree')->save();
            DB::commit();
        }
        catch (SoldeCryptoException $e){
            DB::rollBack();
            throw $e;
        }
    }

    public function insertAchat(Request $request){
        try{
            $request->session()->put("retrait",$this->fondService->createRetrait($request));
            $request->session()->put("entree",$this->createEntree($request));
        }
        catch(SoldeException $e){
            throw $e;
        }
        $response = Http::get('localhost:8082/utilisateur/utilisateur/pin/request/'.$request->session()->get("idUtilisateur"));

        // Vérifier la réponse
        if ($response->successful()) {
            return $response->json(); // Convertit la réponse JSON en tableau PHP
        } else {
            return $response->status(); // Renvoie le code HTTP d'erreur
        }
    }

    public function findListeAchat($idUtilisateur){
        return TransCrypto::with('crypto')->where('idUtilisateur',$idUtilisateur)->where('entree','>',0)->get();
    }

    public function findListeAchatAll(){
        return TransCrypto::where('entree','>',0)->get();
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

    public function findStatistiqueTransaction(\DateTimeInterface $dateMax){
        $transCryptos=TransCrypto::with('utilisateur')->selectRaw('sum(entree*"prixUnitaire") as achat,sum(sortie*"prixUnitaire") as vente, "idUtilisateur"')
            ->groupBy('idUtilisateur')
            ->where('dateTransaction','<=',$dateMax->format('Y-m-d H:i:s'))
            ->orderBy('idUtilisateur','asc')
            ->get();

        foreach ($transCryptos as $transCrypto){
            $transCrypto->solde=$this->fondService->findSoldeFilter($transCrypto->idUtilisateur,$dateMax);
        }
        return $transCryptos;
    }

    public function findSoldeCrypto($idUtilisateur,$idCrypto){
        return TransCrypto::where('idUtilisateur',$idUtilisateur)
            ->where('idCrypto',$idCrypto)
            ->selectRaw('sum(entree-sortie) as solde')
            ->first()['solde'];
    }

    public function findPorfeuilleUtilisateur($idUtilisateur){
        return TransCrypto::where('idUtilisateur',$idUtilisateur)
            ->with('crypto')
            ->selectRaw('sum(entree-sortie) as solde,"idCrypto"')
            ->groupBy('idCrypto')
            ->get();
    }

    public function findListVente($idUtilisateur):Collection{
        return TransCrypto::with('crypto')->where("sortie",">",0)->Where("idUtilisateur",$idUtilisateur)->get();
    }

    public function findAllTransaction()
    {
        $transactions = TransCrypto::with('utilisateur')->orderBy('dateTransaction','desc')->paginate(10);
        return $transactions;
    }
}
