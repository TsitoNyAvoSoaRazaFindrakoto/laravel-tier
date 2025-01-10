<?php

namespace App\DTO;

class TokenDTO
{
    public int $id_token;
    public string $token;
    public \DateTime $date_expiration;

    public function __construct(int $id_token, string $token, \DateTime $date_expiration)
    {
        $this->id_token = $id_token;
        $this->token = $token;
        $this->date_expiration = $date_expiration;
    }
}
