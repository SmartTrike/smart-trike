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
    Schema::table('fare_settings', function (Blueprint $table) {
        $table->decimal('terminal_fare', 10, 2)->nullable()->change();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
      Schema::table('fare_settings', function (Blueprint $table) {
        // Ibalik sa dati (hindi nullable) kung sakaling i-rollback
        $table->decimal('terminal_fare', 10, 2)->nullable(false)->change();
    });
    }
};
