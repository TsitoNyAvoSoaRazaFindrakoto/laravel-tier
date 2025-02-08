<?php

namespace App\Exception;

class TokenException extends \Exception
{
    public function __construct(){
        parent::__construct("Token expiré ou invalide");
    }
}
