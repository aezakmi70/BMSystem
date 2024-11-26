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
        Schema::create('official_tbl', function (Blueprint $table) {
            $table->id(); // This defaults to an unsigned bigint as primary key
            $table->string('position', 50);
            $table->text('completeName');
            $table->text('email');
            $table->string('contactNumber', 20);
            $table->text('address');
            $table->date('termStart');
            $table->date('termEnd');
            $table->string('status', 20);
            $table->string('password', 255);
            $table->timestamps(); // Automatically adds created_at and updated_at fields with timestamp type
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('official_tbl');
    }
};
