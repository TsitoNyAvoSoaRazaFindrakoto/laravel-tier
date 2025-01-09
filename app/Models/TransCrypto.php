<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransCrypto extends Model
{
    protected $table = 'transCrypto';
    protected $guarded = ["idTransCrypto"];
    protected $primaryKey = "idTransCrypto";

    public $timestamps = false;
}
