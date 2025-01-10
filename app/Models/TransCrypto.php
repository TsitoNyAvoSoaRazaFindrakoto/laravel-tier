<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TransCrypto extends Model
{
    protected $table = 'transCrypto';
    protected $guarded = ["idTransCrypto"];
    protected $primaryKey = "idTransCrypto";

    public $timestamps = false;

     /**
     * Relation "Appartient à" avec le modèle Crypto.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function crypto(): BelongsTo
    {
        return $this->belongsTo(Crypto::class, 'idCrypto');
    }
}
