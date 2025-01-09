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
		DB::statement("CREATE TABLE crypto(
				\"idCrypto\" SERIAL,
				\"crypto\" VARCHAR(50)  NOT NULL,
				PRIMARY KEY(\"idCrypto\"),
				UNIQUE(crypto)
			 )");

		DB::statement("CREATE TABLE \"transCrypto\"(
   \"idTransCrypto\" SERIAL,
   \"idUtilisateur\" INTEGER NOT NULL,
   \"entree\" NUMERIC(15,2)  ,
   \"sortie\" NUMERIC(15,2)  ,
   \"dateTransaction\" TIMESTAMP NOT NULL,
   \"idCrypto\" INTEGER NOT NULL,
   PRIMARY KEY(\"idTransCrypto\"),
   FOREIGN KEY(\"idCrypto\") REFERENCES crypto(\"idCrypto\")
	)");

		DB::statement("CREATE TABLE fondUtilisateur(
			\"idTransFond\" SERIAL,
			\"entree\" NUMERIC(20,2) NOT NULL,
			\"sortie\" NUMERIC(20,2) NOT NULL,
			\"idUtilisateur\" INTEGER NOT NULL,
			PRIMARY KEY(\"idTransFond\")
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
