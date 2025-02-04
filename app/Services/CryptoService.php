<?php

namespace App\Services;

use App\Models\Crypto;
use App\Models\CryptoPrix;
use App\Models\FondUtilisateur;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

final class CryptoService
{
    public function findPriceCrypto():Collection{
        return CryptoPrix::with('crypto')->whereRaw("\"dateHeure\" in (select max(\"dateHeure\") from \"cryptoPrix\" group by \"idCrypto\")")->get();
    }

    public function findFirstQuartile($idCryptos,$dateHeureMin,$dateHeureMax):Collection{
        return CryptoPrix::selectRaw('percentile_cont(0.25) WITHIN GROUP (ORDER BY "prixUnitaire") AS "stat", "idCrypto"')
            ->where(function (Builder $query) use ($idCryptos){
                for ($i=0;$i<count($idCryptos) ;$i++){
                    if($i==0){
                        $query->where('idCrypto',$idCryptos[$i]);
                    }
                    else{
                        $query->orWhere('idCrypto',$idCryptos[$i]);
                    }
                }
            })
            ->where('dateHeure','>=',$dateHeureMin)
            ->where('dateHeure','<=',$dateHeureMax)
            ->groupBy('idCrypto')
            ->get();
    }

    public function findEvolutionChart($idCrypto){
        $cryptoEvolution=CryptoPrix::with('crypto')->selectRaw('"dateHeure" as label, "prixUnitaire" as data')
            ->where('idCrypto',$idCrypto)
            ->orderBy('dateHeure','desc')
            ->limit(10)
            ->get();
        $cryptoEvolution = $cryptoEvolution->sortBy('label');
        return $cryptoEvolution;
    }

    public function findFirstQuartileAll($dateHeureMin,$dateHeureMax):Collection{
        return CryptoPrix::selectRaw('percentile_cont(0.25) WITHIN GROUP (ORDER BY "prixUnitaire") AS "stat"')
            ->where('dateHeure','>=',$dateHeureMin)
            ->where('dateHeure','<=',$dateHeureMax)
            ->get();
    }

    public function findMax($idCryptos,$dateHeureMin,$dateHeureMax):Collection{
        return CryptoPrix::selectRaw('max("prixUnitaire") AS "stat", "idCrypto"')
            ->where(function (Builder $query) use ($idCryptos){
                for ($i=0;$i<count($idCryptos) ;$i++){
                    if($i==0){
                        $query->where('idCrypto',$idCryptos[$i]);
                    }
                    else{
                        $query->orWhere('idCrypto',$idCryptos[$i]);
                    }
                }
            })
            ->where('dateHeure','>=',$dateHeureMin)
            ->where('dateHeure','<=',$dateHeureMax)
            ->groupBy('idCrypto')
            ->get();
    }

    public function findMaxAll($dateHeureMin,$dateHeureMax):Collection{
        return CryptoPrix::selectRaw('max("prixUnitaire") AS "stat"')
            ->where('dateHeure','>=',$dateHeureMin)
            ->where('dateHeure','<=',$dateHeureMax)
            ->get();
    }

    public function findMin($idCryptos,$dateHeureMin,$dateHeureMax):Collection{
        return CryptoPrix::selectRaw('min("prixUnitaire") AS "stat", "idCrypto"')
            ->where(function (Builder $query) use ($idCryptos){
                for ($i=0;$i<count($idCryptos) ;$i++){
                    if($i==0){
                        $query->where('idCrypto',$idCryptos[$i]);
                    }
                    else{
                        $query->orWhere('idCrypto',$idCryptos[$i]);
                    }
                }
            })
            ->where('dateHeure','>=',$dateHeureMin)
            ->where('dateHeure','<=',$dateHeureMax)
            ->groupBy('idCrypto')
            ->get();
    }

    public function findMinAll($dateHeureMin,$dateHeureMax):Collection{
        return CryptoPrix::selectRaw('min("prixUnitaire") AS "stat"')
            ->where('dateHeure','>=',$dateHeureMin)
            ->where('dateHeure','<=',$dateHeureMax)
            ->get();
    }

    public function findAverage($idCryptos,$dateHeureMin,$dateHeureMax):Collection{
        return CryptoPrix::selectRaw('avg("prixUnitaire") AS "stat", "idCrypto"')
            ->where(function (Builder $query) use ($idCryptos){
                for ($i=0;$i<count($idCryptos) ;$i++){
                    if($i==0){
                        $query->where('idCrypto',$idCryptos[$i]);
                    }
                    else{
                        $query->orWhere('idCrypto',$idCryptos[$i]);
                    }
                }
            })
            ->where('dateHeure','>=',$dateHeureMin)
            ->where('dateHeure','<=',$dateHeureMax)
            ->groupBy('idCrypto')
            ->get();
    }

    public function findAverageAll($idCryptos,$dateHeureMin,$dateHeureMax):Collection{
        return CryptoPrix::selectRaw('avg("prixUnitaire") AS "stat"')
            ->where('dateHeure','>=',$dateHeureMin)
            ->where('dateHeure','<=',$dateHeureMax)
            ->get();
    }

    public function findEcartType($idCryptos,$dateHeureMin,$dateHeureMax):Collection{
        return CryptoPrix::with(['crypto'])
            ->selectRaw('cast(stddev("prixUnitaire") as double precision) AS "ecartTypeEchantillon", cast(stddev_pop("prixUnitaire") as double precision) AS "ecartTypePopulation", "idCrypto"')
            ->where(function (Builder $query) use ($idCryptos){
                for ($i=0;$i<count($idCryptos) ;$i++){
                    if($i==0){
                        $query->where('idCrypto',$idCryptos[$i]);
                    }
                    else{
                        $query->orWhere('idCrypto',$idCryptos[$i]);
                    }
                }
            })
            ->where('dateHeure','>=',$dateHeureMin)
            ->where('dateHeure','<=',$dateHeureMax)
            ->groupBy('idCrypto')
            ->get();
    }

    public function findEcartTypeAll($dateHeureMin,$dateHeureMax):Collection{
        return CryptoPrix::with(['crypto'])
            ->selectRaw('cast(stddev("prixUnitaire") as double precision) AS "ecartTypeEchantillon", cast(stddev_pop("prixUnitaire") as double precision) AS "ecartTypePopulation"')
            ->where('dateHeure','>=',$dateHeureMin)
            ->where('dateHeure','<=',$dateHeureMax)
            ->get();
    }

    public function findStat(\Illuminate\Http\Request $request):Collection{
        $cryptos = Crypto::all();
        $cryptoAsked = [];
        foreach ($cryptos as $crypto){
            if($request->input($crypto->crypto, null)!=null){
                $cryptoAsked[]=$crypto->idCrypto;
            }
        }
        $responses=[];
        if($request->input('typeAnalyse')=="1er Quartile"){
            $responses=$this->findFirstQuartile($cryptoAsked,$request->input('dateHeureMin'),$request->input('dateHeureMax'));
        }
        else if($request->input('typeAnalyse')=="Maximum"){
            $responses=$this->findMax($cryptoAsked,$request->input('dateHeureMin'),$request->input('dateHeureMax'));
        }
        else if($request->input('typeAnalyse')=="Minimum"){
            $responses=$this->findMin($cryptoAsked,$request->input('dateHeureMin'),$request->input('dateHeureMax'));
        }
        else if($request->input('typeAnalyse')=="Moyenne"){
            $responses=$this->findAverage($cryptoAsked,$request->input('dateHeureMin'),$request->input('dateHeureMax'));
        }
        else{
            $responses=$this->findEcartType($cryptoAsked,$request->input('dateHeureMin'),$request->input('dateHeureMax'));
        }
        if($request->input('Tous',null)!=null){
            $responses[]=$this->findStatAll($request)[0];
            $responses[count($responses)-1]->crypto=new Crypto();
            $responses[count($responses)-1]->crypto->crypto="Tous";
        }
        return $responses;
    }

    public function findStatAll(\Illuminate\Http\Request $request):Collection{
        if($request->input('typeAnalyse')=="1er Quartile"){
            return $this->findFirstQuartileAll($request->input('dateHeureMin'),$request->input('dateHeureMax'));
        }
        if($request->input('typeAnalyse')=="Maximum"){
            return $this->findMaxAll($request->input('dateHeureMin'),$request->input('dateHeureMax'));
        }
        if($request->input('typeAnalyse')=="Minimum"){
            return $this->findMinAll($request->input('dateHeureMin'),$request->input('dateHeureMax'));
        }
        if($request->input('typeAnalyse')=="Moyenne"){
            return $this->findAverageAll($request->input('dateHeureMin'),$request->input('dateHeureMax'));
        }
        return $this->findEcartTypeAll($request->input('dateHeureMin'),$request->input('dateHeureMax'));
    }
}
