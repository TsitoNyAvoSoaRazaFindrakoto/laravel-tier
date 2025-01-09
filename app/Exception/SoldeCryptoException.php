<?php

namespace App\Exception;

class SoldeCryptoException extends \Exception
{
    public function __construct(){
        parent::__construct("Solde insufisante pour cette requete", 500, "Solde insuffisante");
    }
}
