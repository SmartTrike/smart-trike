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
        Schema::create('driver_violations', function (Blueprint $table) {
            $table->id();
            $table->string('violation');
            $table->foreignId('driver_id')
                ->constrained('users')
                ->onDelete('cascade');
            $table->foreignId('filed_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();
            $table->unsignedInteger('suspension_days')->default(0);
            $table->date('suspension_start_date')->nullable();
            $table->date('suspension_end_date')->nullable();
            $table->text('remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('driver_violation');
    }
};
