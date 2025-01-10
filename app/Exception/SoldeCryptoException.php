<?php

namespace App\Exception;

class SoldeCryptoException extends \Exception
{
    public function __construct($quantiteDemande,$quantiteSodle){
        parent::__construct("Solde insufisante pour cette requete. La quantite demande: ".$quantiteDemande." alors que le solde est ".$quantiteSodle, 500);
    }
}
