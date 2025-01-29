<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TransCrypto extends Model
{
    protected $table = 'transCrypto';
    protected $guarded = ["idTransCrypto"];
    protected $primaryKey = "idTransCrypto";

    public $timestamps = false;

     /**
     * Relation "Appartient à" avec le modèle Crypto.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function crypto(): BelongsTo
    {
        return $this->belongsTo(Crypto::class, 'idCrypto');
    }

    public function utilisateur():BelongsTo{
        return $this->belongsTo(Utilisateur::class,"idUtilisateur","idUtilisateur");
    }

    public function getOperationName(): string{
        if($this->entree==0){
            return "Vente";
        }
        return "Achat";
    }

    public function getMontant():float{
        if($this->entree==0){
            return $this->sortie;
        }
        return $this->entree;
    }

    public function setCalculatedValue(){
        if($this->entree==0){
            $this->operation="Vente";
        }
        else{
            $this->operation="Achat";
        }
        if($this->entree==0){
            $this->quantite = $this->sortie;
        }
        else{
            $this->quantite = $this->entree;
        }
    }
}
