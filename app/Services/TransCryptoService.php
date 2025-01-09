<?php

namespace App\Services;

use App\Models\TransCrypto;
use DateTime;
use Illuminate\Http\Request;

class TransCryptoService
{

    protected $fondService;

    public function __construct(FondService $fondService){
        $this->fondService = $fondService;
    }

    public function

    public function insertAchat(Request $request){
        $this->fondService->insertRetrait($request);
    }
}
