<?php

namespace App\Http\Controllers;

use App\Models\Crypto;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
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
}
