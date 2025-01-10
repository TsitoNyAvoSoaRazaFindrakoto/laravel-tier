<?php

namespace App\DTO;

class UtilisateurDTO
{
    public int $id_utilisateur;
    public string $pseudo;
    public string $email;
    public string $password;
    public int $id_tentative_connection;
    public ?PinDTO $pin;
    public ?TokenDTO $token;
    public RoleDTO $role;

    public function __construct(
        int $id_utilisateur,
        string $pseudo,
        string $email,
        string $password,
        int $id_tentative_connection,
        ?PinDTO $pin,
        ?TokenDTO $token,
        RoleDTO $role
    ) {
        $this->id_utilisateur = $id_utilisateur;
        $this->pseudo = $pseudo;
        $this->email = $email;
        $this->password = $password;
        $this->id_tentative_connection = $id_tentative_connection;
        $this->pin = $pin;
        $this->token = $token;
        $this->role = $role;
    }
}
