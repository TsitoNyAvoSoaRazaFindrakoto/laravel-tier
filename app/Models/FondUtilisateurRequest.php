<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FondUtilisateurRequest extends Model
{
    protected $table = 'fondUtilisateurRequest';
    protected $guarded = ["idTransFondRequest"];
    protected $primaryKey = "idTransFondRequest";
    public $timestamps = false;

    public function accept():FondUtilisateur{
        $fondUtilisateur = new FondUtilisateur();
        $fondUtilisateur->sortie=$this->sortie;
        $fondUtilisateur->entree=$this->entree;
        $fondUtilisateur->dateTransaction=$this->dateTransaction;
        $fondUtilisateur->dateValidation=new \DateTime();
        $fondUtilisateur->dateValidation=$fondUtilisateur->dateValidation->format('Y-m-d H:i:s');
        $fondUtilisateur->idUtilisateur=$this->idUtilisateur;
        return $fondUtilisateur;
    }

    public function getOperationName():string{
        if($this->sortie==0){
            return "Depot";
        }
        return "Retrait";
    }

    public function getMontant():float{
        if($this->sortie==0){
            return $this->entree;
        }
        return $this->sortie;
    }

    public function setCalculatedValue(){
        if($this->sortie==0){
            $this->operation = "Depot";
        }
        else{
            $this->operation="Retrait";
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
