<?php

namespace App\Services;

use App\Models\TransCrypto;
use App\Models\Utilisateur;
use Illuminate\Support\Facades\Http;
use Mockery\Exception;
use Illuminate\Http\Request;

final class UtilisateurService
{
    private ImageKitService $imageKitService;

    public function __construct(ImageKitService $imageKit){
        $this->imageKitService = $imageKit;
    }

    public function findById($id):Utilisateur{
        return Utilisateur::where('idUtilisateur', $id)->first();
    }

    public function testToken($token,$idUtilisateur,Request $request){
        $response = Http::get('localhost:8082/utilisateur/utilisateur/test-token?token='.$token.'&idUtilisateur='.$idUtilisateur);

        // Vérifier la réponse
        if (!$response->successful()) {
            throw new Exception("Erreur du fournisseur d'identite"); // Convertit la réponse JSON en tableau PHP
        }
        if($response->json()["status"]==200){
            $request->session()->put("token",$response->json()["data"]);
            return true;
        }
        return false;
    }

    public function findAllImages():array{
        $transactions = TransCrypto::with('utilisateur')->selectRaw("distinct(\"idUtilisateur\") as \"idUtilisateur\"")->get();
        $utilisateurImage=[];
        foreach ($transactions as $transaction){
            $utilisateurImage[$transaction->idUtilisateur]=$this->imageKitService->getImageUrl($transaction->utilisateur->image_id);
        }
        return $utilisateurImage;
    }
}
