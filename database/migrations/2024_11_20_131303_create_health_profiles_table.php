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
        Schema::create('health_profiles_tbl', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('resident_id');   
            $table->string('blood_type', 3)->nullable(); 
            $table->text('allergies')->nullable(); 
            $table->text('medical_conditions')->nullable(); 
            $table->timestamps(); 

            $table->foreign('resident_id')
                ->references('id')
                ->on('resident_tbl')
                ->onDelete('cascade');
        });
        Schema::create('health_services_tbl', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('resident_id');
            $table->date('service_date');
            $table->string('service_type', 30);
            $table->text('description')->nullable();
            $table->string('provided_by')->nullable();
            $table->enum('status', ['Completed', 'Pending', 'Cancelled'])->default('Completed');
            $table->timestamps();

            $table->foreign('resident_id')
                ->references('id')
                ->on('resident_tbl')
                ->onDelete('cascade');
        });
    }
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('health_management_tbl');
        Schema::dropIfExists('health_services');
    }
};
