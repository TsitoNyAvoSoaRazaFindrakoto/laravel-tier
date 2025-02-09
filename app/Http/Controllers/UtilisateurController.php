<?php

namespace App\Http\Controllers;

use App\Models\Crypto;
use App\Models\Utilisateur;
use App\Services\FondService;
use App\Services\ImageKitService;
use App\Services\TransCryptoService;
use App\Services\UtilisateurService;
use Illuminate\Http\Request;

final class UtilisateurController extends Controller
{

    private UtilisateurService $utilisateurService;
    private FondService $fondService;
    private TransCryptoService $cryptoService;
    private ImageKitService $imageKitService;

    public function __construct(UtilisateurService $utilisateurService,FondService $fondService,TransCryptoService $cryptoService,ImageKitService $imageKitService){
        $this->utilisateurService = $utilisateurService;
        $this->fondService = $fondService;
        $this->cryptoService = $cryptoService;
        $this->imageKitService = $imageKitService;
    }

    public function modificationValidated(Request $request){
        $request->validate([
            "token"=>"required",
            "pseudo"=>"required",
        ]);
        if($this->utilisateurService->testToken($request->input("token"),$request->session()->get("idUtilisateur"),$request)){
            $utilisateur=$this->utilisateurService->findById($request->session()->get("idUtilisateur"));
            $utilisateur->pseudo=$request->input("pseudo");
            $utilisateur->save();
            return redirect('/profile');
        }
        return redirect('/connection?message=Token+expire&alert=danger');
    }

    public function modification(Request $request){
        $data["pseudo"]=$this->utilisateurService->findById($request->session()->get("idUtilisateur"))->pseudo;
        $data["token"]=$request->session()->get('token');
        return view('utilisateur.parametre', $data);
    }

    public function profile(Request $request){
        $idUtilisateur=$request->session()->get('idUtilisateur');
        $data["porteFeuilles"]=$this->cryptoService->findSoldeAllCrypto($idUtilisateur);
        $utilisateur=$this->utilisateurService->findById($idUtilisateur);
        $img=$this->imageKitService->getImageUrl($utilisateur->image_id);
        if($img==null){
            $img="https://ik.imagekit.io/qmegcemhav/profile-pictures/default.jpg?updatedAt=1738953528745";
        }
        $utilisateur->email="LizkaRyan626@gmail.com";
        $utilisateur->img=$img;
        $data["utilisateur"]=$utilisateur;
        return $this->getView("utilisateur.profile",$request,$data);
    }

    public function index(){
        return view('utilisateur.accueil');
    }

    public function login(Request $request){
        $message=$request->input("message");
        $alert=$request->input("alert");
        $data["message"]="";
        $data["alert"]="";
        if($message!=null){
            $data["message"]=$message;
            $data["alert"]=$alert;
        }
        return view('utilisateur.login',$data);
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
        $data["isAdmin"]=true;
        $data["images"]=$this->utilisateurService->findAllImages();
        return $this->getView("utilisateur.transactionHistorique",$request,$data);
    }

    public function findListTransaction(Request $request){
        $idCrypto=0;
        $data["cryptos"]=Crypto::all();
        $data["isAdmin"]=false;
        $data["images"]=$this->utilisateurService->findAllImages();
        $data["transactionsCrypto"]=$this->cryptoService->findTransactionHistorique($request->input("dateMin"),$request->input("dateMax"),$request->session()->get("idUtilisateur"),$idCrypto);
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
        $data["isAdmin"]=false;
        $data["images"]=$this->utilisateurService->findAllImages();
        $data["formSubmit"]="/transaction/details/".$idUtilisateur."-utilisateur";
        return $this->getView("utilisateur.transactionHistorique",$request,$data);
    }

    public function setSession(Request $request){
        $idUtilisateur=$request->input('idUtilisateur');
        $pseudo=$request->input('pseudo');
        $role=$request->input('role');
        $token=$request->input('token');
        if(!$this->utilisateurService->testToken($token,$idUtilisateur,$request) && $role!="Admin"){
            return redirect()->route('utilisateur.login');
        }
        $utilisateur=$this->utilisateurService->findById($idUtilisateur);
        if($idUtilisateur==null){
            $utilisateur=new Utilisateur();
            $utilisateur->pseudo=$pseudo;
            $utilisateur->save();
        }
        $request->session()->put('idUtilisateur',$idUtilisateur);
        $request->session()->put('connected',true);
        $request->session()->put('role',$role);
        return redirect("/dashboard/cours-crypto");
    }

    public function logout(Request $request){
        $request->session()->invalidate();
        return redirect("/");
    }

    public function loginFafana(Request $request){
        $request->session()->put('idUtilisateur',1);
        $request->session()->put('role',"Admin");
        $request->session()->put('pseudo',"Lizka");
        $request->session()->put('connected',true);
        return redirect()->route('achat.liste');
    }
}
