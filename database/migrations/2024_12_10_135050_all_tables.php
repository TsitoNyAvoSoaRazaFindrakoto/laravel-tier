<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("CREATE TABLE client(
           \"idClient\" SERIAL,
           numero VARCHAR(255)  NOT NULL,
           \"idPersonne\" INTEGER NOT NULL,
           PRIMARY KEY(\"idClient\"),
           FOREIGN KEY(\"idPersonne\") REFERENCES personne(\"idPersonne\")
        )");

        DB::statement("CREATE TABLE admin(
           \"idAdmin\" SERIAL,
           email VARCHAR(255)  NOT NULL,
           password VARCHAR(255)  NOT NULL,
           \"idPersonne\" INTEGER NOT NULL,
           PRIMARY KEY(\"idAdmin\"),
           FOREIGN KEY(\"idPersonne\") REFERENCES personne(\"idPersonne\")
        )");

        DB::statement("CREATE TABLE \"typeTravaux\"(
           \"idTypeTravaux\" SERIAL,
           \"typeTravaux\" VARCHAR(255)  NOT NULL,
           PRIMARY KEY(\"idTypeTravaux\"),
           UNIQUE(\"typeTravaux\")
        )");
        
        DB::statement("CREATE TABLE unite(
           \"idUnite\" SERIAL,
           unite VARCHAR(50)  NOT NULL,
           PRIMARY KEY(\"idUnite\"),
           UNIQUE(unite)
        )");

        DB::statement("CREATE TABLE \"typeMaison\"(
           \"idTypeMaison\" SERIAL,
           \"typeMaison\" VARCHAR(50)  NOT NULL,
           \"dureeJour\" NUMERIC(12,2)   NOT NULL,
           PRIMARY KEY(\"idTypeMaison\"),
           UNIQUE(\"typeMaison\")
        )");

        DB::statement("CREATE TABLE \"typeFinition\"(
           \"idTypeFinition\" SERIAL,
           \"typeFinition\" VARCHAR(50)  NOT NULL,
           pourcentage NUMERIC(5,2)   NOT NULL,
           PRIMARY KEY(\"idTypeFinition\"),
           UNIQUE(\"typeFinition\")
        )");

        DB::statement("CREATE TABLE paiement(
           \"idPaiement\" SERIAL,
           \"datePaiement\" DATE NOT NULL,
           montant NUMERIC(15,2)   NOT NULL,
           PRIMARY KEY(\"idPaiement\")
        )");

        DB::statement("CREATE TABLE devis(
           \"idDevis\" SERIAL,
           \"dateDebut\" DATE NOT NULL,
           \"idClient\" INTEGER NOT NULL,
           \"idTypeFinition\" INTEGER NOT NULL,
           \"idTypeMaison\" INTEGER NOT NULL,
           PRIMARY KEY(\"idDevis\"),
           FOREIGN KEY(\"idClient\") REFERENCES client(\"idClient\"),
           FOREIGN KEY(\"idTypeFinition\") REFERENCES \"typeFinition\"(\"idTypeFinition\"),
           FOREIGN KEY(\"idTypeMaison\") REFERENCES \"typeMaison\"(\"idTypeMaison\")
        )");

        DB::statement("CREATE TABLE travaux(
           \"idTravaux\" SERIAL,
           montant NUMERIC(15,2)   NOT NULL,
           \"idDevis\" INTEGER NOT NULL,
           \"idTypeTravaux\" INTEGER NOT NULL,
           PRIMARY KEY(\"idTravaux\"),
           FOREIGN KEY(\"idDevis\") REFERENCES devis(\"idDevis\"),
           FOREIGN KEY(\"idTypeTravaux\") REFERENCES \"typeTravaux\"(\"idTypeTravaux\")
        )");

        DB::statement("CREATE TABLE \"travauxDetails\"(
           \"idDevisDetails\" SERIAL,
           designation VARCHAR(255)  NOT NULL,
           quantite NUMERIC(15,2)   NOT NULL,
           \"prixUnitaire\" NUMERIC(15,2)   NOT NULL,
           \"idTravaux\" INTEGER NOT NULL,
           \"idUnite\" INTEGER NOT NULL,
           PRIMARY KEY(\"idDevisDetails\"),
           FOREIGN KEY(\"idTravaux\") REFERENCES travaux(\"idTravaux\"),
           FOREIGN KEY(\"idUnite\") REFERENCES unite(\"idUnite\")
        )");

        DB::statement("CREATE TABLE \"paiementConstruction\"(
           \"idDevis\" INTEGER,
           \"idPaiement\" INTEGER,
           PRIMARY KEY(\"idDevis\", \"idPaiement\"),
           FOREIGN KEY(\"idDevis\") REFERENCES devis(\"idDevis\"),
           FOREIGN KEY(\"idPaiement\") REFERENCES paiement(\"idPaiement\")
        )");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
