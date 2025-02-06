<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Utilisateur extends Model
{
    protected $table = 'utilisateur';
    protected $guarded = ["idUtilisateur"];
    protected $primaryKey = "idUtilisateur";
    public $timestamps = false;

}
