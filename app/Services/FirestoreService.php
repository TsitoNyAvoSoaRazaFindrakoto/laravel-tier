<?php

namespace App\Services;

use DateTime;
use DateTimeInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use InvalidArgumentException;
use Kreait\Firebase\Factory;

class FirestoreService
{
    private $client;
    private $projectId;
    private $databaseId;

    public function __construct() {
        $this->client = new Client();
        $this->projectId = 'crypta-d5e13';  // Remplace avec ton ID de projet
        $this->databaseId = '(default)';  // Utilise la base de données par défaut
    }

    public function insertData($collection, $documentId, $data) {
        $data["mobile"]=false;
        $url = "https://firestore.googleapis.com/v1/projects/{$this->projectId}/databases/{$this->databaseId}/documents/{$collection}/{$documentId}";

        $formattedData = [
            'fields' => $this->formatData($data)
        ];

        $response = $this->client->request('PATCH', $url, [
            'json' => $formattedData
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

    private function formatData($data): array
    {
        $formatted = [];
        foreach ($data as $key => $value) {
            if (is_string($value) && str_starts_with($value, 'projects/')) {
                // Si c'est une référence Firestore
                $formatted[$key] = ['referenceValue' => $value];
            }
            else if (is_string($value)) {
                $formatted[$key] = ['stringValue' => $value];
            } elseif (is_int($value)) {
                $formatted[$key] = ['integerValue' => $value];
            } elseif (is_float($value)) {
                $formatted[$key] = ['doubleValue' => $value];
            } elseif (is_bool($value)) {
                $formatted[$key] = ['booleanValue' => $value];
            } elseif (is_null($value)) {
                $formatted[$key] = ['nullValue' => null];
            } elseif ($value instanceof DateTime) {
                $formatted[$key] = ['timestampValue' => $value->format(DateTimeInterface::ATOM)]; // Format ISO 8601
            } elseif (is_array($value) && $this->isAssoc($value)) {
                // Si la valeur est une map (tableau associatif)
                $formatted[$key] = ['mapValue' => $this->formatData($value)]; // Appel récursif pour formater la map
            } else {
                throw new InvalidArgumentException("Type de valeur non pris en charge pour la clé : $key");
            }
        }
        return $formatted;
    }

    // Fonction pour vérifier si un tableau est associatif (une map)
    private function isAssoc(array $array): bool
    {
        if ([] === $array) return false; // Un tableau vide n'est pas une map
        return array_keys($array) !== range(0, count($array) - 1); // Vérifie si les clés sont numériques
    }
}
