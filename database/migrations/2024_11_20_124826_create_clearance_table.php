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
            $table->text('findings');
            $table->text('purpose');
            $table->integer('orNo');
            $table->integer('samount');
            $table->date('dateRecorded');
            $table->string('recordedBy', 50);
            $table->string('status', 20);
            $table->timestamps(); // Adds created_at and updated_at

            $table->foreign('residentid')
            ->references('id')  // Reference the `id` column of the `residents` table
            ->on('resident_tbl')   // The table where the `id` column exists
            ->onDelete('cascade'); // Optional: Delete the clearance record if the resident is deleted
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
