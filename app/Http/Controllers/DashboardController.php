<?php

namespace App\Http\Controllers;

use App\Models\Crypto;
use App\Services\CryptoService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public CryptoService $cryptoService;

    public function __construct(CryptoService $cryptoService){
        $this->cryptoService = $cryptoService;
    }

    public function index(Request $request)
    {
        return $this->getView('dashboard.index',$request);
    }

    public function parametre(Request $request){
        return $this->getView('dashboard.parameter',$request);
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
            "crypto"=>"required|integer",
            "typeAnalyse"=>"required",
            "dateHeureMin"=>"required|date",
            "dateHeureMax"=>"required|date",
        ]);
        $data["stats"]=$this->cryptoService->findStat($request);
        $data["typeAnalyse"]=$request->input("typeAnalyse");
        return $this->getView('dashboard.analyse.cryptoListe',$request,$data);
    }
}
