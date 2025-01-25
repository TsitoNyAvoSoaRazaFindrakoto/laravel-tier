<?php

namespace App\Services;

use App\Models\Utilisateur;

class UtilisateurService
{
    public function findById($id):Utilisateur{
        return Utilisateur::where('idUtilisateur', $id)->first();
    }
}
