<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FondUtilisateur extends Model
{
    protected $table = 'fond_utilisateur';
    protected $guarded = ["idFondUtilisateur"];
    protected $primaryKey = "idFondUtilisateur";

    public function crypto():BelongsTo{
        return $this->belongsTo(Crypto::class, "idCrypto","idCrypto");
    }
}
