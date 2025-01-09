<?php

namespace App\Exception;

class SoldeException extends \Exception
{
    public function __construct($montantDemande,$solde){
        parent::__construct("Solde insufisante pour cette requete: Le montant que vous voulez "+$montantDemande+" et le solde: "+$solde, 500, "Solde insuffisante");
    }
}
