<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dispatcher_information', function (Blueprint $table) {
            $table->id();

            // FK to users
            $table->foreignId('user_id')
                ->constrained('users')
                ->onDelete('cascade');


            // Dispatcher personal info
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->string('suffix')->nullable();
            $table->string('contact_number')->nullable();
            $table->string('address')->nullable();

    
            $table->enum('status', ['active', 'inactive', 'suspended'])
                ->default('active');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dispatcher_information');
    }
};
