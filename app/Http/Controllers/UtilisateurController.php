<?php

namespace App\Http\Controllers;

use App\Models\Crypto;
use App\Models\Utilisateur;
use App\Services\FondService;
use App\Services\TransCryptoService;
use App\Services\UtilisateurService;
use Illuminate\Http\Request;

class UtilisateurController extends Controller
{

    private UtilisateurService $utilisateurService;
    private FondService $fondService;
    private TransCryptoService $cryptoService;

    public function __construct(UtilisateurService $utilisateurService,FondService $fondService,TransCryptoService $cryptoService){
        $this->utilisateurService = $utilisateurService;
        $this->fondService = $fondService;
        $this->cryptoService = $cryptoService;
    }

    public function login(){
        return view('utilisateur.login');
    }

    public function loginPin(Request $request){
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
            "idCrypto"=>'integer'
        ]);
        $data["transactionsFond"]=$this->fondService->findTransactionHistorique($request->input("dateMin"),$request->input("dateMax"),$request->input("idUtilisateur"));
        $data["transactionsCrypto"]=$this->cryptoService->findTransactionHistorique($request->input("dateMin"),$request->input("dateMax"),$request->input("idUtilisateur"),$request->input("idCrypto"));
        $data["dateMin"]=$request->input("dateMin");
        $data["dateMax"]=$request->input("dateMax");
        $data["cryptos"]=Crypto::all();
        $data["idCrypto"]=$request->input("idCrypto");
        $data["formSubmit"]="/liste/transaction/historique";
        return $this->getView("utilisateur.transactionHistorique",$request,$data);
    }

    public function findTransactionsUser(string $idUtilisateur,Request $request){
        $request->validate([
            "dateMin"=>'date',
            "dateMax"=>'date',
            "idCrypto"=>'integer'
        ]);
        $data["transactionsFond"]=$this->fondService->findTransactionHistorique($request->input("dateMin"),$request->input("dateMax"),$idUtilisateur);
        $data["transactionsCrypto"]=$this->cryptoService->findTransactionHistorique($request->input("dateMin"),$request->input("dateMax"),$idUtilisateur,$request->input("idCrypto"));
        $data["dateMin"]=$request->input("dateMin");
        $data["dateMax"]=$request->input("dateMax");
        $data["cryptos"]=Crypto::all();
        $data["idCrypto"]=$request->input("idCrypto");
        $data["formSubmit"]="/liste/transaction/".$idUtilisateur;
        return $this->getView("utilisateur.transactionHistorique",$request,$data);
    }

    public function setSession(Request $request){
        $idUtilisateur=$request->input('idUtilisateur');
        $pseudo=$request->input('pseudo');
        if($request->session()->get('token')!=$request->input('token')){
            return redirect()->route('utilisateur.login');
        }
        $utilisateur=$this->utilisateurService->findById($idUtilisateur);
        if($idUtilisateur==null){
            $utilisateur=new Utilisateur();
            $utilisateur->pseudo=$pseudo;
            $utilisateur->save();
        }
        $request->session()->put('utilisateur',$utilisateur);
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
