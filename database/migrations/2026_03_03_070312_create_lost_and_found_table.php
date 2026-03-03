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
        Schema::create('lost_and_found', function (Blueprint $table) {
            $table->id();
            $table->string('item_name');
            $table->text('description');
            $table->enum('type', ['lost', 'found'])->default('found');
            $table->enum('status', ['reported', 'claimed', 'returned', 'disposed'])->default('reported');

            // Who reported it (Driver or User)
            $table->foreignId('reported_by')->constrained('users')->onDelete('cascade');

            // Who updated the status (Dispatcher/Admin)
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');

            $table->timestamp('date_found_lost')->nullable();
            $table->string('location_found_lost')->nullable(); // e.g., "Inside Sidecar #123"
            $table->text('remarks')->nullable();
            $table->string('image_path')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lost_and_found');
    }
};
