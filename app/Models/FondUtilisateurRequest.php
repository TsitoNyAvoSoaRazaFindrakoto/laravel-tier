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
        $fondUtilisateur->idUtilisateur=$this->idUtilisateur;
        return $fondUtilisateur;
    }

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

    public function utilisateur():BelongsTo{
        return $this->belongsTo(Utilisateur::class,"idUtilisateur","idUtilisateur");
    }
}
