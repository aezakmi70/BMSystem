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
        Schema::create('income_tbl', function (Blueprint $table) {
            $table->id();
            $table->string('source'); // Description of income source
            $table->decimal('amount', 10, 2); // Income amount
            $table->date('date'); // Date income was recorded
            $table->foreignId('certificate_request_id') // Foreign key
                  ->nullable()
                  ->constrained('clearance_tbl') // Assuming your certificate requests table is named 'tblclearance'
                  ->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('income_tbl');
    }
};