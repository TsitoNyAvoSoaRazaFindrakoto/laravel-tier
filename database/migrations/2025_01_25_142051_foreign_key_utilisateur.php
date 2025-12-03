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
        DB::statement("alter table \"fondUtilisateur\" add constraint foreign_key_utilisateur_fond FOREIGN KEY(\"idUtilisateur\") REFERENCES utilisateur(\"idUtilisateur\")");
        DB::statement("alter table \"fondUtilisateurRequest\" add constraint foreign_key_utilisateur_fond_request FOREIGN KEY(\"idUtilisateur\") REFERENCES utilisateur(\"idUtilisateur\")");
        DB::statement("alter table \"transCrypto\" add constraint foreign_key_trans_crypto FOREIGN KEY(\"idUtilisateur\") REFERENCES utilisateur(\"idUtilisateur\")");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
