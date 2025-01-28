<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FondUtilisateur extends Model
{
    protected $table = 'fondUtilisateur';
    protected $guarded = ["idTransFond"];
    protected $primaryKey = "idTransFond";
    public $timestamps = false;

    public function getOperationName():string{
        if($this->sortie==0){
            return "Retrait";
        }
        return "Depot";
    }

    public function getMontant():float{
        if($this->sortie==0){
            return $this->entree;
        }
        return $this->sortie;
    }

    public function setCalculatedValue(){
        if($this->sortie==0){
            $this->operation = "Retrait";
        }
        else{
            $this->operation="Depot";
        }
        if($this->sortie==0){
            $this->montant=$this->entree;
        }
        else{
            $this->montant=$this->sortie;
        }
    }

    public function utilisateur():BelongsTo{
        return $this->belongsTo(Utilisateur::class,"idUtilisateur","idUtilisateur");
    }
}
