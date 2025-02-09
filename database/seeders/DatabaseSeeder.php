<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;  // Ajouter l'utilisation de DB pour faire des insertions directes
use Carbon\Carbon; // Pour manipuler les dates de manière facile

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Insertion des données dans la table crypto
        DB::table('crypto')->insert([
            ['crypto' => 'BitCoin'],
            ['crypto' => 'Ethereum'],
            ['crypto' => 'ValCoin'],
        ]);

        // Insertion des données dans fondUtilisateur avec une date de transaction
        DB::table('fondUtilisateur')->insert([
            ['idUtilisateur' => 1, 'entree' => 1000, 'sortie' => 0, 'dateTransaction' => Carbon::now()],
            ['idUtilisateur' => 1, 'entree' => 0, 'sortie' => 500, 'dateTransaction' => Carbon::now()],
        ]);

        // Insertion des données dans transCrypto avec une date de transaction
        DB::table('transCrypto')->insert([
            ['idUtilisateur' => 1, 'entree' => 10, 'sortie' => 0, 'prixUnitaire' => 200, 'dateTransaction' => '2024-10-10', 'idCrypto' => 1],
            ['idUtilisateur' => 1, 'entree' => 5, 'sortie' => 0, 'prixUnitaire' => 100, 'dateTransaction' => '2024-10-11', 'idCrypto' => 1],
            ['idUtilisateur' => 1, 'entree' => 0, 'sortie' => 7, 'prixUnitaire' => 200, 'dateTransaction' => '2024-10-10', 'idCrypto' => 2],
        ]);

        // Insertion des données dans cryptoPrix avec une date de transaction
        DB::table('cryptoPrix')->insert([
            ['prixUnitaire' => 10000, 'dateHeure' => '2024-10-10T10:00:00.0', 'idCrypto' => 1],
            ['prixUnitaire' => 10000, 'dateHeure' => '2024-10-10T10:00:00.0', 'idCrypto' => 2],
            ['prixUnitaire' => 20000, 'dateHeure' => '2024-10-10T10:00:00.0', 'idCrypto' => 3],
        ]);
    }
}
