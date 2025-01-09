<?php

namespace App\Http\Controllers;

use App\Models\Crypto;
use App\Services\CryptoService;
use App\Services\TransCryptoService;
use Illuminate\Http\Request;

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

    public function formAchat(){
        $data["cryptos"] = Crypto::all();
        return view('cryptos.formAchat',$data);
    }
}
