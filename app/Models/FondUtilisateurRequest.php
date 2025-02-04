<?php

namespace App\Models;

use App\Config\ParameterConfig;
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
        if($this->entree!=0){
            $fondUtilisateur->entree=$this->entree;
            $fondUtilisateur->sortie=0;
        }

        else if($this->sortie!=0){
            $fondUtilisateur->entree=0;
            $fondUtilisateur->sortie=$this->sortie;
        }
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
        if($this->entree>0){
            $this->operation="Depot";
            $this->styleClass="text-success";
            $this->icon="mdi mdi-arrow-top-right";
        }
        else{
            $this->operation="Retrait";
            $this->styleClass="text-danger";
            $this->icon="mdi mdi-arrow-bottom-right";
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
