<?php

namespace App\Http\Controllers;

use App\Config\ParameterConfig;
use App\Dto\Chart;
use App\Models\Crypto;
use App\Services\CommissionService;
use App\Services\CryptoService;
use Illuminate\Http\Request;

final class DashboardController extends Controller
{
    public CryptoService $cryptoService;
    public CommissionService $commissionService;

    public function __construct(CryptoService $cryptoService,CommissionService $commissionService){
        $this->cryptoService = $cryptoService;
        $this->commissionService = $commissionService;
    }

    public function cours(){
        return $this->cryptoService->findPriceCrypto();
    }

    public function coursView(Request $request){
        $idCrypto=1;
        $data["evolutionCryptos"]=Chart::createChart($this->cryptoService->findEvolutionChart($idCrypto));
        $data["idCrypto"]=$idCrypto;
        $data["crypto"]=Crypto::findOrFail($idCrypto);
        $data["cours"]=$this->cryptoService->findPriceCrypto();
        return $this->getView('dashboard.cours',$request,$data);
    }

    public function cryptoPrix(int $idCrypto){
        return Chart::createChart($this->cryptoService->findEvolutionChart($idCrypto));
    }

    public function index(Request $request)
    {
        $request->validate([
            "idCrypto"=>'integer'
        ]);
        $data["cryptos"]=Crypto::all();
        $idCrypto=$request->input('idCrypto');
        if($idCrypto==null){
            $idCrypto=$data["cryptos"][0]->idCrypto;
        }
        $data["evolutionCryptos"]=Chart::createChart($this->cryptoService->findEvolutionChart($idCrypto));
        $data["idCrypto"]=$idCrypto;
        $data["crypto"]=Crypto::findOrFail($idCrypto);
        return $this->getView('dashboard.index',$request,$data);
    }

    public function parametre(Request $request){
        return $this->getView('dashboard.parameter',$request,ParameterConfig::findCommissionData());
    }

    public function analyseCommission(Request $request){
        $data["cryptos"]=Crypto::all();
        return $this->getView('dashboard.analyse.commission',$request,$data);
    }

    public function analyseCrypto(Request $request){
        $data["cryptos"]=Crypto::all();
        return $this->getView('dashboard.analyse.crypto',$request,$data);
    }

    public function analyseCryptoListe(Request $request){
        $request->validate([
            "typeAnalyse"=>"required",
            "dateHeureMin"=>"required|date",
            "dateHeureMax"=>"required|date",
        ]);
        $data["stats"]=$this->cryptoService->findStat($request);
        $data["typeAnalyse"]=$request->input("typeAnalyse");
        return $this->getView('dashboard.analyse.cryptoListe',$request,$data);
    }

    public function analyseCommissionListe(Request $request){
        $request->validate([
            "crypto"=>"required|integer",
            "typeAnalyse"=>"required",
            "dateHeureMin"=>"required|date",
            "dateHeureMax"=>"required|date",
        ]);
        $data["stats"]=$this->commissionService->findStat($request);
        $data["typeAnalyse"]=$request->input("typeAnalyse");
        return $this->getView('dashboard.analyse.cryptoListe',$request,$data);
    }

    public function parametreUpdate(Request $request){
        $request->validate([
            "achatCommission"=>"required|numeric",
            "venteCommission"=>"required|numeric",
        ]);
        ParameterConfig::updateComissionData($request->input("achatCommission"),$request->input("venteCommission"));
        return redirect()->route('dashboard.parametre');
    }
}
