<?php

namespace App\Console\Commands;

use App\Models\Crypto;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class CryptoUpdaterCommand extends Command
{
	protected $signature = 'crypto:run';
	protected $description = 'Continuously update cryptocurrency values every 10 seconds';

	public function handle()
	{

		$this->info('Crypto value updater started. Press Ctrl+C to stop.');

		while (true) {
			$this->updateCryptoValues(); // Update values
			sleep(10);
		}
	}

	private function updateCryptoValues()
	{
		$cryptos = Crypto::all()->pluck('idCrypto')->toArray();
		
		// Retrieve current cached values
		$cryptoHistory = Cache::get('crypto_val', [$this->initializeCryptoCache($cryptos)]);
		$newValues = $this->generateRandomValue($cryptos, $cryptoHistory[0]);

		// Add new values to the beginning of the array
		array_unshift($cryptoHistory, $newValues);

		// Keep only the latest 10 entries
		$cryptoHistory = array_slice($cryptoHistory, 0, 10);

		// Update the cache
		Cache::put('crypto_val', $cryptoHistory, 15); // Store for 15 minutes

		$this->info('Updated crypto values: ' . json_encode($newValues));
	}

	private function generateRandomValue(array $cryptoIds, array $oldValues)
	{
		$newValues = [];
		$isHighVolatility = rand(0, 100) < 10; // 10% de chances d'un mouvement brusque

		foreach ($cryptoIds as $crypto) {
			$oldValue = $oldValues[$crypto] ?? rand(1000, 50000); // Utilise une valeur existante ou génère une valeur initiale
			$minChange = $isHighVolatility ? -0.5 : -0.1; // Définir la variation minimum
			$maxChange = $isHighVolatility ? 0.5 : 0.1;  // Définir la variation maximum

			// Générer une variation aléatoire en pourcentage
			$percentageChange = rand($minChange * 1000, $maxChange * 1000) / 1000;

			// Calculer la nouvelle valeur
			$newValue = $oldValue * (1 + $percentageChange / 100);
			$newValues[$crypto] = round($newValue, 2); // Arrondir à 2 décimales
		}

		return $newValues;
	}

	private function initializeCryptoCache(array $cryptoIds)
	{
		$initialValues = [];

		foreach ($cryptoIds as $crypto) {
			// Generate random initial values for each crypto
			$initialValues[$crypto] = rand(1000, 50000); // Example range for initial values
		}
		// Save these values in the cache as the first entry
		$cryptoHistory = [$initialValues]; // Start the history with only the initial values
		return $cryptoHistory;
	}
}
