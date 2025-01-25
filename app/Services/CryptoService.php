<?php

namespace App\Services;

use App\Models\CryptoPrix;
use App\Models\FondUtilisateur;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

final class CryptoService
{
    public function findFirstQuartile($idCrypto,$dateHeureMin,$dateHeureMax):Collection{
        return CryptoPrix::selectRaw('percentile_cont(0.25) WITHIN GROUP (ORDER BY "prixUnitaire") AS "stat", "idCrypto"')
            ->where(function (Builder $query) use ($idCrypto){
                if($idCrypto!=0){
                    $query->where('idCrypto',$idCrypto);
                }
            })
            ->where('dateHeure','>=',$dateHeureMin)
            ->where('dateHeure','<=',$dateHeureMax)
            ->groupBy('idCrypto')
            ->get();
    }

    public function findMax($idCrypto,$dateHeureMin,$dateHeureMax):Collection{
        return CryptoPrix::selectRaw('max("prixUnitaire") AS "stat", "idCrypto"')
            ->where(function (Builder $query) use ($idCrypto){
                if($idCrypto!=0){
                    $query->where('idCrypto',$idCrypto);
                }
            })
            ->where('dateHeure','>=',$dateHeureMin)
            ->where('dateHeure','<=',$dateHeureMax)
            ->groupBy('idCrypto')
            ->get();
    }

    public function findMin($idCrypto,$dateHeureMin,$dateHeureMax):Collection{
        return CryptoPrix::selectRaw('min("prixUnitaire") AS "stat", "idCrypto"')
            ->where(function (Builder $query) use ($idCrypto){
                if($idCrypto!=0){
                    $query->where('idCrypto',$idCrypto);
                }
            })
            ->where('dateHeure','>=',$dateHeureMin)
            ->where('dateHeure','<=',$dateHeureMax)
            ->groupBy('idCrypto')
            ->get();
    }

    public function findAverage($idCrypto,$dateHeureMin,$dateHeureMax):Collection{
        return CryptoPrix::selectRaw('avg("prixUnitaire") AS "stat", "idCrypto"')
            ->where(function (Builder $query) use ($idCrypto){
                if($idCrypto!=0){
                    $query->where('idCrypto',$idCrypto);
                }
            })
            ->where('dateHeure','>=',$dateHeureMin)
            ->where('dateHeure','<=',$dateHeureMax)
            ->groupBy('idCrypto')
            ->get();
    }

    public function findEcartType($idCrypto,$dateHeureMin,$dateHeureMax):Collection{
        return CryptoPrix::with(['crypto'])
            ->selectRaw('cast(stddev("prixUnitaire") as double precision) AS "ecartTypeEchantillon", cast(stddev_pop("prixUnitaire") as double precision) AS "ecartTypePopulation", "idCrypto"')
            ->where(function (Builder $query) use ($idCrypto){
                if($idCrypto!=0){
                    $query->where('idCrypto',$idCrypto);
                }
            })
            ->where('dateHeure','>=',$dateHeureMin)
            ->where('dateHeure','<=',$dateHeureMax)
            ->groupBy('idCrypto')
            ->get();
    }

    public function findStat(\Illuminate\Http\Request $request):Collection{
        if($request->input('typeAnalyse')=="1er Quartile"){
            return $this->findFirstQuartile($request->input('crypto'),$request->input('dateHeureMin'),$request->input('dateHeureMax'));
        }
        if($request->input('typeAnalyse')=="Maximum"){
            return $this->findMax($request->input('crypto'),$request->input('dateHeureMin'),$request->input('dateHeureMax'));
        }
        if($request->input('typeAnalyse')=="Minimum"){
            return $this->findMin($request->input('crypto'),$request->input('dateHeureMin'),$request->input('dateHeureMax'));
        }
        if($request->input('typeAnalyse')=="Moyenne"){
            return $this->findAverage($request->input('crypto'),$request->input('dateHeureMin'),$request->input('dateHeureMax'));
        }
        return $this->findEcartType($request->input('crypto'),$request->input('dateHeureMin'),$request->input('dateHeureMax'));
    }
}
