<?php

namespace App\Services;

use App\Models\Utilisateur;

final class UtilisateurService
{
    public function findById($id):Utilisateur{
        return Utilisateur::where('idUtilisateur', $id)->first();
    }
}
