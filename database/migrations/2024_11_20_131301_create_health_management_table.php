<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('health_management', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->unsignedBigInteger('residentid'); // Foreign key to residents table
            $table->string('blood_type', 3)->nullable(); // Blood type (e.g., A+, O-)
            $table->text('allergies')->nullable(); // List of allergies
            $table->text('medical_conditions')->nullable(); // Medical conditions
            $table->json('vaccination_history')->nullable(); // Vaccination history as JSON
            $table->timestamps(); // Created_at and updated_at fields

            // Foreign key constraint (assuming a residents table exists)
            $table->foreign('residentid')
                ->references('id')
                ->on('residents')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('health_management');
    }
};
