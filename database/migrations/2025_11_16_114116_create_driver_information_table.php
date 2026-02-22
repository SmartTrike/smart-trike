<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('driver_information', function (Blueprint $table) {
            $table->id();

            // FK to users table
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            // Driver personal details
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->string('suffix')->nullable();

            $table->string('contact_number')->nullable();
            $table->string('address')->nullable();
            $table->date('birthdate')->nullable();
            $table->string('license_number')->nullable();
            $table->date('license_expiry_date')->nullable();

            // Operator details
            $table->string('operator_name')->nullable();
            $table->string('operator_contact')->nullable();
            $table->string('operator_address')->nullable();

            // Tricycle information
            $table->string('mtop_number')->nullable();        // Motorized Tricycle Operator Permit (MTOP)
            $table->string('tricycle_body_number')->nullable();
            $table->string('plate_number')->nullable();
            $table->string('engine_number')->nullable();
            $table->string('chassis_number')->nullable();
            $table->string('color')->nullable();
            $table->string('model')->nullable();
            $table->year('year_acquired')->nullable();

            // Status
            $table->enum('status', ['active', 'inactive', 'suspended'])->default('active');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('driver_information');
    }
};
