<?php

namespace App\Services;

use App\Models\TransCrypto;
use App\Models\Utilisateur;

final class UtilisateurService
{
    private ImageKitService $imageKitService;

    public function __construct(ImageKitService $imageKit){
        $this->imageKitService = $imageKit;
    }

    public function findById($id):Utilisateur{
        return Utilisateur::where('idUtilisateur', $id)->first();
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
