<?php

namespace App\Services;

use App\Exception\SoldeCryptoException;
use App\Exception\SoldeException;
use App\Models\CryptoPrix;
use App\Models\FondUtilisateur;
use App\Models\TransCrypto;
use DateTime;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Mockery\Exception;

final class TransCryptoService
{

    protected FondService $fondService;
    private CommissionService $commissionService;
    private FirestoreService $firestoreService;

    public function __construct(FondService $fondService, CommissionService $commissionService, FirestoreService $firestoreService)
    {
        $this->fondService = $fondService;
        $this->commissionService = $commissionService;
        $this->firestoreService = $firestoreService;
    }

    public function insertEntree(Request $request)
    {
        $transCrypto = $this->createEntree($request);
        $transCrypto->save();
    }

    public function createEntree(Request $request)
    {
        $today = new DateTime();
        $transCrypto = new TransCrypto();
        $transCrypto->idUtilisateur = $request->session()->get('idUtilisateur');
        $transCrypto->dateTransaction = $today->format('Y-m-d');
        $transCrypto->entree = floatval($request->input('quantite'));
        $transCrypto->prixUnitaire = floatval(CryptoPrix::where('idCrypto', $request->input('idCrypto'))->orderBy('dateHeure', 'desc')->first()->prixUnitaire);
        $transCrypto->sortie = 0;
        $transCrypto->idCrypto = intval($request->input('idCrypto'));
        return $transCrypto;
    }

    public function insertSortie(Request $request)
    {
        $quantite = $request->input('quantite');
        $solde = $this->findSoldeCrypto($request->session()->get('idUtilisateur'), $request->input('idCrypto'));
        if ($quantite > $solde) {
            throw new SoldeCryptoException($quantite, $solde);
        }
        $today = new DateTime();
        $transCrypto = new TransCrypto();
        $transCrypto->idUtilisateur = $request->session()->get('idUtilisateur');
        $transCrypto->dateTransaction = $today->format('Y-m-d');
        $transCrypto->entree = 0;
        $transCrypto->prixUnitaire = CryptoPrix::where('idCrypto', $request->input('idCrypto'))->orderBy('dateHeure', 'desc')->first()->prixUnitaire;
        $transCrypto->sortie = $request->input('quantite');
        $transCrypto->idCrypto = $request->input('idCrypto');
        $transCrypto->save();
        return $transCrypto;
    }

    public function insertAchatValidated(Request $request): array
    {
        $request->validate([
            "quantite" => "required|numeric",
            "idCrypto" => "required|numeric"
        ]);

        try {
            DB::beginTransaction();
            [$fondUtilisateur,$commission] = $this->fondService->createRetrait($request);
            $transaction = $this->createEntree($request);

            $fondUtilisateur->dateValidation = new \DateTime();
            $fondUtilisateur->dateValidation = $fondUtilisateur->dateValidation->format('Y-m-d H:i:s');

            $fondUtilisateur->save();
            $this->commissionService->insertCommission($commission, $transaction->idCrypto);
            $transaction->save();
            DB::commit();
        } catch (SoldeCryptoException $e) {
            DB::rollBack();
            throw $e;
        }
        $fondUtilisateur->utilisateur;
        $transaction->utilisateur;
        $data["fondUtilisateur"] = $fondUtilisateur;
        $data["transaction"] = $transaction;
        return $data;
    }

    public function insertAchat(Request $request): array
    {
        $request->validate([
            "quantite" => "required|numeric",
            "idCrypto" => "required|numeric"
        ]);

        $response = Http::get('localhost:8082/utilisateur/utilisateur/pin/request/' . $request->session()->get("idUtilisateur"));

        // Vérifier la réponse
        if (!$response->successful()) {
            throw new Exception("Erreur du fournisseur d'identite"); // Convertit la réponse JSON en tableau PHP
        }

        $data["token"]=$response->json()["data"];
        $data["quantite"]=$request->input('quantite');
        $data["idCrypto"]=$request->input('idCrypto');
        return $data;
    }

    public function findListeAchat($idUtilisateur)
    {
        return TransCrypto::with('crypto')->where('idUtilisateur', $idUtilisateur)->where('entree', '>', 0)->get();
    }

    public function findTransactionHistorique($dateMin, $dateMax, $idUtilisateur, $idCrypto): \Illuminate\Support\Collection
    {
        if ($dateMin == null) {
            $dateMin = new \DateTime("0001-01-01");
            $dateMin = $dateMin->format('Y-m-d');
        }
        if ($dateMax == null) {
            $dateMax = new \DateTime("9999-12-31");
            $dateMax = $dateMax->format('Y-m-d');
        }
        $query = TransCrypto::with('utilisateur', 'crypto')->where('dateTransaction', '>=', $dateMin)->where('dateTransaction', '<=', $dateMax);
        if ($idCrypto != 0) {
            $query = $query->where('idCrypto', $idCrypto);
        }
        if ($idUtilisateur != 0) {
            $query = $query->where('idUtilisateur', $idUtilisateur);
        }
        $responses = $query->get();
        foreach ($responses as $response) {
            $response->setCalculatedValue();
        }
        return $responses;
    }

    public function findListeAchatAll()
    {
        return TransCrypto::where('entree', '>', 0)->get();
    }

    public function insertVente(Request $request)
    {
        try {
            DB::beginTransaction();
            [$depot, $commission] = $this->fondService->insertDepot($request);
            $this->commissionService->insertCommission($commission, $request->input('idCrypto'));
            $transaction = $this->insertSortie($request);
            $transaction->utilisateur;
            $depot->utilisateur;
            DB::commit();
        } catch (SoldeCryptoException $e) {
            DB::rollBack();
            throw $e;
        }
        $data["transaction"]=$transaction;
        $data["fondUtilisateur"]=$depot;
        return $data;
    }

    public function findStatistiqueTransaction(\DateTimeInterface $dateMax)
    {
        $transCryptos = TransCrypto::with('utilisateur')->selectRaw('sum(entree*"prixUnitaire") as achat,sum(sortie*"prixUnitaire") as vente, "idUtilisateur"')
            ->groupBy('idUtilisateur')
            ->where('dateTransaction', '<=', $dateMax->format('Y-m-d H:i:s'))
            ->orderBy('idUtilisateur', 'asc')
            ->get();

        foreach ($transCryptos as $transCrypto) {
            $transCrypto->solde = $this->fondService->findSoldeFilter($transCrypto->idUtilisateur, $dateMax);
        }
        return $transCryptos;
    }

    public function findSoldeCrypto($idUtilisateur, $idCrypto)
    {
        return TransCrypto::where('idUtilisateur', $idUtilisateur)
            ->where('idCrypto', $idCrypto)
            ->selectRaw('sum(entree-sortie) as solde')
            ->first()['solde'];
    }

    public function findPorfeuilleUtilisateur($idUtilisateur)
    {
        return TransCrypto::where('idUtilisateur', $idUtilisateur)
            ->with('crypto')
            ->selectRaw('sum(entree-sortie) as solde,"idCrypto"')
            ->groupBy('idCrypto')
            ->get();
    }

    public function findListVente($idUtilisateur): Collection
    {
        return TransCrypto::with('crypto')->where("sortie", ">", 0)->Where("idUtilisateur", $idUtilisateur)->get();
    }

    public function findAllTransaction()
    {
        $transactions = TransCrypto::with('utilisateur')->orderBy('dateTransaction', 'desc')->paginate(10);
        return $transactions;
    }
}
