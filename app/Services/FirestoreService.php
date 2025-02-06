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

    /**
     * @throws GuzzleException
     */
    public function findDataInFirestore($url,$query){
        $client = new \GuzzleHttp\Client();

        $response = $client->post($url,[
            'json'=>$query
        ]);

        $data = json_decode($response->getBody(), true);

        foreach ($data as $item) {
            if (isset($item['document']['fields'])) {
                $fields = $item['document']['fields'];
                $parsedData = $this->parseFirestoreData($fields);
                print_r($parsedData);
            }
        }

        return $data;
    }

    public function parseFirestoreData(array $fields): array {
        $parsed = [];
        foreach ($fields as $key => $value) {
            if (isset($value['stringValue'])) {
                $parsed[$key] = $value['stringValue'];
            } elseif (isset($value['integerValue'])) {
                $parsed[$key] = (int) $value['integerValue'];
            } elseif (isset($value['doubleValue'])) {
                $parsed[$key] = (float) $value['doubleValue'];
            } elseif (isset($value['booleanValue'])) {
                $parsed[$key] = (bool) $value['booleanValue'];
            } elseif (isset($value['timestampValue'])) {
                $parsed[$key] = new DateTime($value['timestampValue']);
            } elseif (isset($value['arrayValue'])) {
                $parsed[$key] = array_map(function ($item) {
                    return parseFirestoreData($item['mapValue']['fields'] ?? []);
                }, $value['arrayValue']['values'] ?? []);
            } elseif (isset($value['mapValue'])) {
                $parsed[$key] = parseFirestoreData($value['mapValue']['fields']);
            } else {
                $parsed[$key] = null;
            }
        }
        return $parsed;
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
            } else {
                throw new InvalidArgumentException("Type de valeur non pris en charge pour la clé : $key");
            }
        }
        return $formatted;
    }
}
