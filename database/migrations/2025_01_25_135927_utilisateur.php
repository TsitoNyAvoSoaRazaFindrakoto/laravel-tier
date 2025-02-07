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
        DB::statement("CREATE TABLE utilisateur(
                           \"idUtilisateur\" INTEGER,
                           pseudo VARCHAR(50)  NOT NULL,
                           image_id VARCHAR(100),
                           PRIMARY KEY(\"idUtilisateur\"),
                           UNIQUE(pseudo)
                        )
	    ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP TABLE IF EXISTS \"utilisateur\"");
    }
};
