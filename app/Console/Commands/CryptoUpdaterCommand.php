<?php

namespace App\Console\Commands;

use App\Models\Crypto;
use App\Models\CryptoPrix;
use Illuminate\Console\Command;
use Kreait\Firebase\Factory;

class CryptoUpdaterCommand extends Command
{
	protected $signature = 'crypto:run';
	protected $description = 'Continuously update cryptocurrency values every 10 seconds';
    protected $database;

    public function __construct(){
        parent::__construct();
        $firebaseCredentialsPath = storage_path(env('FIREBASE_CREDENTIALS', 'firebase/firebase_credentials.json'));
        $factory = (new Factory)
            ->withServiceAccount($firebaseCredentialsPath)
            ->withDatabaseUri('https://crypta-d5e13-default-rtdb.firebaseio.com/'); // URL correcte de la base de données

        $this->database = $factory->createDatabase();
    }

	public function handle()
	{
		$this->info('Crypto value updater started. Press Ctrl+C to stop.');

		while (true) {
            $this->sendBaseToFirebase();
			$this->updateCryptoValues(); // Update values
			sleep(10);
		}
	}

    private function sendBaseToFirebase(){
        $cryptos=Crypto::all();
        foreach ($cryptos as $crypto) {
            $this->sendCryptoToFirebase($crypto->idCrypto);
        }
    }

    private function sendCryptoToFirebase($idCrypto){
        $prix=CryptoPrix::where("idCrypto",$idCrypto)
            ->orderBy("dateHeure","desc")
            ->selectRaw('"prixUnitaire" as valeur, "dateHeure" as time, "idCryptoPrix"')
            ->limit(30)
            ->get();

        $reference = $this->database->getReference($idCrypto);

        $priceSend=[];

        foreach ($prix as $value) {
            $priceSend["".$value->idCryptoPrix]=[
                "valeur"=> $value->valeur,
                "dateHeure"=> $value->time
            ];
        }
        $reference->set($priceSend);
    }

	private function updateCryptoValues()
	{
		$cryptos = Crypto::all()->pluck('idCrypto')->toArray();
		$latestValues = $this->getLatestCryptoValues($cryptos);

		$newValues = $this->generateRandomValue($cryptos, $latestValues);

		foreach ($newValues as $cryptoId => $price) {
			CryptoPrix::create([
				'prixUnitaire' => $price,
				'dateHeure' => now(),
				'idCrypto' => $cryptoId,
			]);
		}
		$this->info('Updated crypto values: ' . json_encode($newValues));
	}

	private function getLatestCryptoValues(array $cryptoIds): array
	{
		$latestValues = CryptoPrix::whereIn('idCrypto', $cryptoIds)
			->orderBy('dateHeure', 'desc')
			->get()
			->groupBy('idCrypto')
			->map(function ($group) {
				// If no records are found for the crypto, generate a random value
				if ($group->isEmpty()) {
					return $this->generateRandomCryptoValue();
				}
				return $group->first()->prixUnitaire;
			})
			->toArray();

		return $latestValues;
	}

	private function generateRandomCryptoValue(): float
	{
		// Example of plausible range for cryptocurrency prices
		$minValue = 1000;   // Minimum value for the cryptocurrency
		$maxValue = 50000;  // Maximum value for the cryptocurrency

		// Generate a random value within the range
		return round(rand($minValue * 100, $maxValue * 100) / 100, 2);  // round to 2 decimals
	}

	private function generateRandomValue(array $cryptoIds, array $oldValues)
	{
		$newValues = [];
		$isHighVolatility = rand(0, 100) < 10; // 10% chance of a big change

		foreach ($cryptoIds as $cryptoId) {
			$oldValue = $oldValues[$cryptoId] ?? rand(1000, 50000); // Use previous value or generate an initial one
			$minChange = $isHighVolatility ? -0.5 : -0.1; // Min % change
			$maxChange = $isHighVolatility ? 0.5 : 0.1;  // Max % change

			// Generate random percentage change
			$percentageChange = rand($minChange * 100, $maxChange * 100);

			// Calculate the new value
			$newValue = max($oldValue * (1 + $percentageChange / 100), 0.01);
			$newValues[$cryptoId] = round($newValue, 2); // Round to 2 decimals
		}
		return $newValues;
	}
}
