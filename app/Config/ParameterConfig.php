<?php

namespace App\Config;
use Illuminate\Support\Facades\Storage;

class ParameterConfig
{
    protected static string $fileName='config/config.properties';

    public static function findCommissionData()
    {
        // Vérifier si le fichier existe
        if (Storage::disk('local')->exists(ParameterConfig::$fileName)) {
            // Lire le contenu du fichier
            $content = Storage::disk('local')->get(ParameterConfig::$fileName);

            // Convertir en tableau associatif
            $lines = explode("\n", $content);
            $data = [];
            foreach ($lines as $line) {
                // Ignorer les lignes vides ou commentaires
                if (trim($line) === '' || str_starts_with(trim($line), '#')) {
                    continue;
                }

                [$key, $value] = explode('=', $line, 2);
                $data[trim($key)] = trim($value);
            }

            return $data;
        }
        return []; // Retourner un tableau vide si le fichier n'existe pas
    }

    public static function updateComissionData($commissionAchat,$commissionVente)
    {
        // Lire les données existantes
        $data = ParameterConfig::findCommissionData();

        // Ajouter ou mettre à jour des clés
        $data['commission_achat'] = $commissionAchat;
        $data['commission_vente'] = $commissionVente;

        // Reconstruire le contenu
        $properties = '';
        foreach ($data as $key => $value) {
            $properties .= "$key=$value\n";
        }

        // Écrire les données mises à jour
        Storage::disk('local')->put(ParameterConfig::$fileName, $properties);
    }
}
