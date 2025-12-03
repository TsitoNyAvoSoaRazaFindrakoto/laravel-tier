<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        \Illuminate\Support\Facades\DB::statement("CREATE TABLE commission(
        \"idCommission\" SERIAL,
        \"dateCommission\" TIMESTAMP NOT NULL,
        montant Decimal(15,2)  NOT NULL,
        \"idCrypto\" INTEGER NOT NULL,
        PRIMARY KEY(\"idCommission\"),
        FOREIGN KEY(\"idCrypto\") REFERENCES crypto(\"idCrypto\")
        )
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commission');
    }
};
