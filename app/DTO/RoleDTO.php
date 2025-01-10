<?php

namespace App\DTO;

class RoleDTO
{
    public int $id_role;
    public string $role;

    public function __construct(int $id_role, string $role)
    {
        $this->id_role = $id_role;
        $this->role = $role;
    }
}
