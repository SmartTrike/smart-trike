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
        Schema::create('rides', function (Blueprint $table) {
            $table->id();
            $table->foreignId('driver_id')->constrained('users')->onDelete('cascade');  // Foreign key from users table
            $table->foreignId('dispatcher_id')->constrained('users')->onDelete('cascade');  // Foreign key from users table 
            $table->integer('passenger_count')->nullable();
            $table->timestamp('dispatch_at');
            $table->timestamp('returned_at');
            $table->enum('status', ['ongoing', 'completed', 'cancelled'])->default('ongoing');
            $table->text('remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rides');
    }
};
