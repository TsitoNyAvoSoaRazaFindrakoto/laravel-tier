<?php

namespace App\DTO;

class UtilisateurDTO
{
    public int $id_utilisateur;
    public string $pseudo;
    public string $email;
    public string $password;
    public RoleDTO $role;

    public function __construct(
        int $id_utilisateur,
        string $pseudo,
        string $email,
        string $password,
        RoleDTO $role
    ) {
        $this->id_utilisateur = $id_utilisateur;
        $this->pseudo = $pseudo;
        $this->email = $email;
        $this->password = $password;
        $this->role = $role;
    }

}
