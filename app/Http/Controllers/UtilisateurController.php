<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UtilisateurController extends Controller
{

    public function index(){
        return view('utilisateur.index');
    }
    
    public function login(){
        return view('utilisateur.login');
    }

    public function loginPin(Request $request){
        $data["url"]=$request->input('url');
        $data['token']=$request->input('token');
        $request->session()->put('token',$data['token']);
        return view('utilisateur.pin',$data);
    }

    public function inscription(){
        return view('utilisateur.inscription');
    }

    public function findTransactionHistorique(Request $request){
        $request->validate([
            "dateMin"=>'date',
            "dateMax"=>'date',
        ]);
        $idCrypto=$request->input("idCrypto");
        if($idCrypto==null){
            $idCrypto=0;
        }
        $data["transactionsCrypto"]=$this->cryptoService->findTransactionHistorique($request->input("dateMin"),$request->input("dateMax"),$request->input("idUtilisateur"),$idCrypto);
        $data["dateMin"]=$request->input("dateMin");
        $data["dateMax"]=$request->input("dateMax");
        $data["cryptos"]=Crypto::all();
        $data["idCrypto"]=$request->input("idCrypto");
        $data["formSubmit"]="/transaction/historique";
        return $this->getView("utilisateur.transactionHistorique",$request,$data);
    }

    public function findTransactionsUser(string $idUtilisateur,Request $request){
        $request->validate([
            "dateMin"=>'date',
            "dateMax"=>'date'
        ]);
        $idCrypto=$request->input("idCrypto");
        if($idCrypto==null){
            $idCrypto=0;
        }
        $data["transactionsCrypto"]=$this->cryptoService->findTransactionHistorique($request->input("dateMin"),$request->input("dateMax"),$idUtilisateur,$idCrypto);
        $data["dateMin"]=$request->input("dateMin");
        $data["dateMax"]=$request->input("dateMax");
        $data["cryptos"]=Crypto::all();
        $data["idCrypto"]=$request->input("idCrypto");
        $data["formSubmit"]="/transaction/details/".$idUtilisateur."-utilisateur";
        return $this->getView("utilisateur.transactionHistorique",$request,$data);
    }

    public function setSession(Request $request){
        if($request->session()->get('token')!=$request->input('token')){
            return redirect()->route('utilisateur.login');
        }
        $request->session()->put('idUtilisateur',$request->input('idUtilisateur'));
        $request->session()->put('role',$request->input('role'));
        $request->session()->put('connected',true);
        return redirect()->route('achat.liste');
    }

    public function logout(Request $request){
        $request->session()->invalidate();
        return redirect("/");
    }

    public function loginFafana(Request $request){
        $request->session()->put('idUtilisateur',1);
        $request->session()->put('role',"Admin");
        $request->session()->put('connected',true);
        return redirect()->route('achat.liste');
    }
}
