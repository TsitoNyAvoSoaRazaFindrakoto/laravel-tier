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
        DB::statement("alter table utilisateur add column image_id varchar(100)");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("alter table utilisateur drop column image_id");
    }
};
