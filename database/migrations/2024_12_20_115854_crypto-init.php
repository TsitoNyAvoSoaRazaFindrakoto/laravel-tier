<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
	/**
	 * Run the migrations.
	 */
	public function up(): void
	{
		DB::statement("CREATE TABLE crypto(
			\"idCrypto\" SERIAL,
			\"crypto\" VARCHAR(50) NOT NULL,
			PRIMARY KEY(\"idCrypto\"),
			UNIQUE(\"crypto\")
		)");

		DB::statement("CREATE TABLE \"transCrypto\"(
			\"idTransCrypto\" SERIAL,
			\"idUtilisateur\" INTEGER NOT NULL,
			\"entree\" NUMERIC(15,2)  ,
			\"sortie\" NUMERIC(15,2)  ,
			\"dateTransaction\" TIMESTAMP NOT NULL,
			\"prixUnitaire\" DECIMAL(15,2) NOT NULL,
			\"idCrypto\" INTEGER NOT NULL,
			PRIMARY KEY(\"idTransCrypto\"),
			FOREIGN KEY(\"idCrypto\") REFERENCES crypto(\"idCrypto\")
		)");

		DB::statement("CREATE TABLE fondutilisateur(
			\"idTransFond\" SERIAL,
			\"entree\" NUMERIC(20,2) NOT NULL,
			\"sortie\" NUMERIC(20,2) NOT NULL,
			\"idUtilisateur\" INTEGER NOT NULL,
			\"dateTransaction\" TIMESTAMP NOT NULL,
			PRIMARY KEY(\"idTransFond\")
		)");

		DB::statement("CREATE TABLE \"cryptoPrix\"(
			\"idCryptoPrix\" SERIAL,
			\"prixUnitaire\" NUMERIC(20,2) NOT NULL,
			\"dateHeure\" TIMESTAMP NOT NULL,
			\"idCrypto\" INTEGER NOT NULL,
			PRIMARY KEY(\"idCryptoPrix\"),
			FOREIGN KEY(\"idCrypto\") REFERENCES \"crypto\"(\"idCrypto\")
		)");
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		DB::statement("DROP TABLE IF EXISTS \"cryptoPrix\"");
		DB::statement("DROP TABLE IF EXISTS \"fondUtilisateur\"");
		DB::statement("DROP TABLE IF EXISTS \"transCrypto\"");
		DB::statement("DROP TABLE IF EXISTS \"crypto\"");
	}
};
