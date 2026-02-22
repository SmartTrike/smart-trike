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
        Schema::create('logs', function (Blueprint $table) {
             $table->id();
    $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
    $table->string('event_type');  // e.g. 'checked_in', 'dispatched'
    $table->text('details')->nullable();  // Additional information
    $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('logs');
    }
};
