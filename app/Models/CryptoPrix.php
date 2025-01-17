<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CryptoPrix extends Model
{
    protected $table = 'cryptoPrix';
    protected $guarded = ["idCryptoPrix"];
    protected $primaryKey = "idCryptoPrix";

		// Disable timestamps
    public $timestamps = false;

    public function crypto():BelongsTo{
        return $this->belongsTo(Crypto::class, "idCrypto","idCrypto");
    }
}
