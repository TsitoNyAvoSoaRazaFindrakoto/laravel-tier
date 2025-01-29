<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FondUtilisateur extends Model
{
    protected $table = 'fondutilisateur';
    protected $guarded = ["idTransFond"];
    protected $primaryKey = "idTransFond";
    public $timestamps = false;

    public function crypto():BelongsTo{
        return $this->belongsTo(Crypto::class, "idCrypto","idCrypto");
    }
}
