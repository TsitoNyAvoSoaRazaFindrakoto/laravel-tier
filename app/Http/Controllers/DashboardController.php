<?php

namespace App\Http\Controllers;

use App\Models\Crypto;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard');
    }

    public function parametre(){
        return view('dashboard.parameter');
    }

    public function analyseCommission(){
        $data["cryptos"]=Crypto::all();
        return view('dashboard.analyse.commission',$data);
    }

    public function analyseCrypto(){
        $data["cryptos"]=Crypto::all();
        return view('dashboard.analyse.crypto',$data);
    }
}
