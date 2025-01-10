<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CryptoPrix extends Model
{
    protected $table = 'cryptoPrix';
    protected $guarded = ["idCryptoPrix"];
    protected $primaryKey = "idCryptoPrix";

		// Disable timestamps
    public $timestamps = false;
}
