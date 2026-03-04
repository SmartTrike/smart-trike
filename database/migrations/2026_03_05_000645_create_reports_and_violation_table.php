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
        Schema::create('reports', function (Blueprint $table) {
            $table->id();

            $table->text('description');

            $table->enum('status', [
                'reported',   
                'invalid',    // rejected
                'approved'    // valid → violation will be created
            ])->default('reported');

            // Who reported it
            $table->foreignId('reported_by')
                ->constrained('users')
                ->cascadeOnDelete();

            // Driver being reported
            $table->foreignId('driver_id')
                ->constrained('users')
                ->cascadeOnDelete();

            // Admin / dispatcher who reviewed
            $table->foreignId('reviewed_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            // Link to violation (VERY IMPORTANT)
            $table->foreignId('violation_id')
                ->nullable()
                ->constrained('driver_violations')
                ->nullOnDelete();

            $table->timestamp('event_date')->nullable();
            $table->text('remarks')->nullable();

            $table->string('evidence_image_path')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports_and_violation');
    }
};
