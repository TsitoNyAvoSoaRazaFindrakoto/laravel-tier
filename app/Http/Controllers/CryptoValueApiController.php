<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CryptoValueApiController extends Controller
{
	public function getCryptoValues()
	{
		// Retrieve the cached crypto values
		$cryptoHistory = Cache::get('crypto_values', []);

		if (empty($cryptoHistory)) {
			return response()->json(['message' => 'Pas de crypto monnaies dans la base'], 404);
		}

		// Return the latest 10 values
		return response()->json($cryptoHistory);
	}
}
