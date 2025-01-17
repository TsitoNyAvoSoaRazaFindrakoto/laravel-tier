<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Commission extends Model
{

    protected $table = 'commission';
    protected $guarded = ["idCommission"];
    protected $primaryKey = "idCommission";
    public $timestamps = false;

    public function crypto():BelongsTo{
        return $this->belongsTo(Crypto::class, "idCrypto","idCrypto");
    }
}
