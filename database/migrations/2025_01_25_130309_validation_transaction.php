<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("CREATE TABLE \"fondUtilisateurRequest\"(
                        \"idTransFondRequest\" SERIAL,
                       \"entree\" NUMERIC(20,2)   NOT NULL,
                       \"sortie\" NUMERIC(20,2)   NOT NULL,
                       \"idUtilisateur\" INTEGER NOT NULL,
                       \"dateTransaction\" TIMESTAMP  NOT NULL,
                       PRIMARY KEY(\"idTransFondRequest\")
                    )
	    ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP TABLE IF EXISTS \"fondUtilisateurRequest\"");
    }
};
