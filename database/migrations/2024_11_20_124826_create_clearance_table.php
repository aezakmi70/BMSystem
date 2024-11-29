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
        Schema::create('clearance_tbl', function (Blueprint $table) {
            $table->id(); // Auto-increment primary ke
            $table->string('residentName');
            $table->unsignedBigInteger('residentid');
            $table->unsignedBigInteger('residentAge');
            $table->date('residentBirthdate');
            $table->text('certificateToIssue');
            $table->text('purpose');
            $table->integer('orNo');
            $table->integer('samount');
            $table->date('dateRecorded');
            $table->string('recordedBy', 50);
            $table->string('status', 20);
            $table->timestamps(); // Adds created_at and updated_at
            $table->text('businessName')->nullable();
            $table->text('businessAddress')->nullable();
            $table->string('typeOfBusiness', 50)->nullable();
            $table->foreign('residentid')
            ->references('id')  // Reference the `id` column of the `residents` table
            ->on('resident_tbl')   // The table where the `id` column exists
            ->onDelete('cascade'); // Optional: Delete the clearance record if the resident is deleted
            $table->foreign('residentAge')
                ->references('age') // Reference the `age` column from the `resident_tbl`
                ->on('resident_tbl')
                ->onDelete('cascade');

            $table->foreign('residentBirthdate')
                ->references('birthdate') // Reference the `birthdate` column from the `resident_tbl`
                ->on('resident_tbl')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clearance_tbl');
    }
};
