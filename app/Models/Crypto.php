<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Crypto extends Model
{
    protected $table = 'crypto';
    protected $guarded = ["idCrypto"];
    protected $primaryKey = "idCrypto";
}
