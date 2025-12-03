<?php

namespace App\Services;

use App\Models\Commission;
use Illuminate\Http\Request;

final class CommissionService
{
    private function findSumCommission($idCrypto,$dateMin,$dateMax){
        return Commission::selectRaw('SUM(montant) as stat,"idCrypto"')
            ->where(function ($query) use ($idCrypto){
                if($idCrypto!=0){
                    $query->where('idCrypto',$idCrypto);
                }
            })
            ->whereBetween('dateCommission',[$dateMin,$dateMax])
            ->groupBy('idCrypto')
            ->get();
    }

    private function findAverageCommission($idCrypto,$dateMin,$dateMax){
        return Commission::selectRaw('AVG(montant) as stat,"idCrypto"')
            ->where(function ($query) use ($idCrypto){
                if($idCrypto!=0){
                    $query->where('idCrypto',$idCrypto);
                }
            })
            ->whereBetween('dateCommission',[$dateMin,$dateMax])
            ->groupBy('idCrypto')
            ->get();
    }

    public function findStat(Request $request){
        if($request->input('typeAnalyse')=="Somme"){
            return $this->findSumCommission($request->input('crypto'),$request->input('dateHeureMin'),$request->input('dateHeureMax'));
        }
        return $this->findAverageCommission($request->input('crypto'),$request->input('dateHeureMin'),$request->input('dateHeureMax'));
    }

    public function insertCommission($commissionMontant,$idCrypto)
    {
        $commission = new Commission();
        $commission->dateCommission=new \DateTime();
        $commission->dateCommission=$commission->dateCommission->format('Y-m-d H:i:s');
        $commission->montant=$commissionMontant;
        $commission->idCrypto=$idCrypto;
        $commission->save();
    }
}
