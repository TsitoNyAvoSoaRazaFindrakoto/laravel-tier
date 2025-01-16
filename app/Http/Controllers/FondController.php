<?php

namespace App\Http\Controllers;

use App\Models\FondUtilisateur;
use App\Services\FondService;
use Illuminate\Http\Request;

class FondController extends Controller
{
    protected FondService $fondService;
    public function __construct(FondService $fondService)
    {
        $this->fondService = $fondService;
    }

    public function formDepot(){
        return view('fond.formDepot');
    }
    public function insertDepot(Request $request){
        $request->validate([
            "montant"=>"required|numeric|min:1",
        ]);
        $this->fondService->insertDepotWithoutCrypto($request);
    }

    public function formRetrait(){
        return view('fond.formRetrait');
    }

    public function insertRetrait(Request $request){
        $request->validate([
            "montant"=>"required|numeric|min:1",
        ]);
        $this->fondService->insertRetraitWithoutCrypto($request);
        return redirect()->route('portefeuille.liste');
    }
}
