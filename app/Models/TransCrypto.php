<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransCrypto extends Model
{
    protected $table = 'transcrypto';
    protected $guarded = ["idTransCrypto"];
    protected $primaryKey = "idTransCrypto";
}
